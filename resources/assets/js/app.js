/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example', require('./components/Example.vue'));
import Vue from "vue"
import VueRouter from "vue-router"
import Vuetify from "vuetify"
import "vuetify/dist/vuetify.min.css"
import store from "./store"

import { extend, ValidationObserver, ValidationProvider } from "vee-validate"
import { required, email } from "vee-validate/dist/rules"

Vue.use(Vuetify)
Vue.use(VueRouter)

Vue.component("ValidationObserver", ValidationObserver)
Vue.component("ValidationProvider", ValidationProvider)
extend("required", required)
extend("email", email)

import Login from "Pages/Login"
import Dashboard from "Pages/Dashboard"

const routes = [
  { name: "Login", path: "/login", component: Login },
  { name: "Dashboard", path: "/dashboard", component: Dashboard }]

const router = new VueRouter({
  mode: "history",
  routes,
})
const app = new Vue({
  vuetify: new Vuetify(),
  router,
  store,
}).$mount("#app")
