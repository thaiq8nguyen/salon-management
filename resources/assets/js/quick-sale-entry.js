import Vue from 'vue';
import axios from 'axios';
import Vuetify from 'vuetify';
import VeeValidate from 'vee-validate';
import moment from 'moment';


Vue.use(Vuetify);
Vue.use(VeeValidate);

Object.defineProperty(Vue.prototype,'$axios',{value:axios});
Object.defineProperty(Vue.prototype, '$moment',{value:moment});

axios.defaults.headers.common ={
    'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};
import PrimaryNavBar from './components/admin/PrimaryNavBar.vue'
import QuickSaleEntry from './components/admin/QuickSaleEntry.vue';
Vue.component('primary-nav-bar', PrimaryNavBar);
Vue.component('quick-sale-entry', QuickSaleEntry);

const app = new Vue({


    el: '#root'
});