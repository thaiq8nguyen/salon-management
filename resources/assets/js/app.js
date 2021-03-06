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
import Vue from "vue";

import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
import "@mdi/font/css/materialdesignicons.css";
import customPlugins from "Plugins";

import store from "./store";
import router from "./router";

import Main from "./Main";

import { extend, ValidationObserver, ValidationProvider } from "vee-validate";
import { email, min_value, required, regex } from "vee-validate/dist/rules";

Vue.use(Vuetify);
Vue.use(customPlugins);

Vue.component("ValidationObserver", ValidationObserver);
Vue.component("ValidationProvider", ValidationProvider);

extend("email", email);
extend("min_value", {
  ...min_value,
  message: "The amount must be greater than 0"
});
extend("regex", {
  ...regex,
  message: "The amount must be a number"
});
extend("required", required);

new Vue({
  vuetify: new Vuetify(),
  router,
  store,
  components: { Main },
  template: "<Main/>"
}).$mount("#app");
