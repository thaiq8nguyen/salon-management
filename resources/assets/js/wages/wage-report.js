import Vue from 'vue';
import {http} from '../axios-http';

import Vuetify from 'vuetify';
import moment from 'moment';


Vue.use(Vuetify);

Object.defineProperty(Vue.prototype,'$http',{value:http});
Object.defineProperty(Vue.prototype, '$moment',{value:moment});


import WageReportApp from '../components/wages/WageReportApp.vue'


const app = new Vue({
    el: '#root',

    components:{
        WageReportApp,
    },

});