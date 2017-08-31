import Vue from 'vue';
import {http} from '../axios-http';

import Vuetify from 'vuetify';
import moment from 'moment';


Vue.use(Vuetify);

Object.defineProperty(Vue.prototype,'$http',{value:http});
Object.defineProperty(Vue.prototype, '$moment',{value:moment});

/*axios.defaults.headers.common ={
    'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'
};*/
import WageReportApp from '../components/wages/WageReportApp.vue'


const app = new Vue({
    el: '#root',

    components:{
        WageReportApp,
    },
    data:{

    },

    mounted(){
        //this.getPayPeriod();
    },
    methods:{
        /*getPayPeriod(){
            this.$http.get('pay-period/list').then(response =>{
                //console.log(response.data);
            });
        }*/
    },

});