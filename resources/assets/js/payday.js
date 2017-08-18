import Vue from 'vue';
import axios from 'axios';
import Vuetify from 'vuetify';
import moment from 'moment';
import PayPeriodHeader from './components/partials/PayPeriodHeader.vue';
import PayDay from './components/PayDay.vue';


Vue.use(Vuetify);

Object.defineProperty(Vue.prototype,'$axios',{value:axios});
Object.defineProperty(Vue.prototype, '$moment',{value:moment});

axios.defaults.headers.common ={
    'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};

Vue.component('pay-period-header',PayPeriodHeader);
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

