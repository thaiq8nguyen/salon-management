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

import GiftCertificate from '../components/salon/GiftCertificate.vue';

//console.log(Math.abs(window.orientation) === 90 ? 'landscape' : 'portrait');


Vue.component('app', GiftCertificate);
const app = new Vue({
    el: '#root',
    data:{
        orientation:{degree:window.orientation},
    },


    watch:{
       orientation(){
           this.readDeviceOrientation(this.orientation);
       }

    },

    computed:{
        mode(){
            return window.orientation;
        }
    },



    methods:{

        readDeviceOrientation(degree){
            let orientation = null;

            if(Math.abs(degree) === 90){
                orientation = 'landscape';
            }
            else{
                orientation = 'portrait';
            }

            alert(this.orientation);
        }
    }
});