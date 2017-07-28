/**
 * Created by Thai Nguyen on 5/8/2017.
 */

import Vue from 'vue';
import axios from 'axios';
import moment from 'moment-es6';
import Vuetify from 'vuetify';

import TechnicianHeader from './components/TechnicianHeader.vue';
import PayPeriodHeader from './components/PayPeriodHeader.vue';
import NewTechnicianSale from './components/NewTechnicianSale.vue';

Object.defineProperty(Vue.prototype,'$axios',{value:axios});
Object.defineProperty(Vue.prototype, '$moment',{value:moment});


Vue.use(Vuetify);

axios.defaults.headers.common ={
    'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'

};

Vue.component('technician-header', TechnicianHeader);
Vue.component('pay-period-header', PayPeriodHeader);
Vue.component('new-technician-sale', NewTechnicianSale);

const app = new Vue({
        el: '#root',
        data: {
            periodID:'',
            technician:{
                firstName:'',
                fullName:''
            }

        },


        methods: {

            getTechnician(name){
                this.technician.fullName = name;
            },
            setPayPeriod(id){
                this.periodID = id;
            }
        }
    });
