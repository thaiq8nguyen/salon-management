
import Vue from 'vue';
import axios from 'axios';
import moment from 'moment';
import Vuetify from 'vuetify';

Vue.use(Vuetify);

Object.defineProperty(Vue.prototype,'$axios',{value:axios});
Object.defineProperty(Vue.prototype, '$moment',{value:moment});

axios.defaults.headers.common ={
    'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

import PrimaryNavBar from './components/admin/PrimaryNavBar.vue';
import Home from './components/admin/Home.vue';

Vue.component('primary-nav-bar', PrimaryNavBar);
Vue.component('home',Home);

const app = new Vue({
    el:'#root',

});
