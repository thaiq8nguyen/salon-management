/**
 * Created by Thai Nguyen on 5/8/2017.
 */

import Vue from 'vue';
import axios from 'axios';
import moment from 'moment';
import Vuetify from 'vuetify';

import TechnicianHeader from './components/common/TechnicianHeader.vue';
import PayPeriodHeader from './components/partials/PayPeriodHeader.vue';
import NewTechnicianSale from './components/admin/NewTechnicianSale.vue';

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

window.Event = new Vue();

const app = new Vue({
        el: '#root',
        data: {
            periodID:'',
            technicianName:''

        },


        methods: {

            getTechnician(fullName){
                this.technicianName = fullName;
            },
            setPayPeriod(id){
                this.periodID = id;
            }
        }
    });
