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


import PayDay from './components/admin/PayDay.vue';

Vue.component('pay-day',PayDay);


window.Event = new Vue();

const app = new Vue({
    el:'#root',

    data:{
        periodId:null,

    },
    methods:{
        setPayPeriod(id){
            this.periodId = id;
        }
    }
});

