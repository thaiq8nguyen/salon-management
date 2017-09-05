import Vue from 'vue';
import Vuetify from 'vuetify';
import moment from 'moment';
import {http} from './axios-http';
import PaymentReportsViewer from './components/admin/PaymentReportsViewer.vue';

Vue.use(Vuetify);
Object.defineProperty(Vue.prototype,'$http',{value:http});
Object.defineProperty(Vue.prototype, '$moment',{value:moment});

const app = new Vue({
    el: '#root',

    components:{
        PaymentReportsViewer,
    },

    data:{

    },

    methods:{

    }
});