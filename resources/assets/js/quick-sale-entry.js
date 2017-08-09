import Vue from 'vue';
import axios from 'axios';
import Vuetify from 'vuetify';
import moment from 'moment';


Vue.use(Vuetify);

Object.defineProperty(Vue.prototype,'$axios',{value:axios});
Object.defineProperty(Vue.prototype, '$moment',{value:moment});

axios.defaults.headers.common ={
    'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

import QuickSaleEntry from './components/QuickSaleEntry.vue';
Vue.component('quick-sale-entry', QuickSaleEntry);

const app = new Vue({


    el: '#root'
});