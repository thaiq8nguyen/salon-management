import Vue from 'vue'
import HttpPlugin from './http.js';
import Vuetify from 'vuetify';
import lodash from 'lodash';
import ApiDashboard from './components/admin/ApiDashboard.vue'


Vue.use(Vuetify);
Vue.use(HttpPlugin);

Object.defineProperty(Vue.prototype, '$_', {value:lodash});




const app = new Vue({
    el:'#root',
    components:{ApiDashboard}
});
