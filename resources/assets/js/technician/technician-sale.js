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

import TechnicianSale from '../components/technician/TechnicianSale.vue';

const app = new Vue({
    el:'#root',
    components:{
        TechnicianSale
    },
    data:{

    },
    methods:{

    },
});