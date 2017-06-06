import {$,jQuery} from 'jquery';
import Vue from 'vue';
import axios from 'axios';
import moment from 'moment-es6';

window.$ =  $;
window.jQuery = jQuery;

window.Vue = Vue;
window.axios = axios;

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

window.moment = moment;