/**
 * Created by discoverylight on 6/3/17.
 */

require('./bootstrap');

import Client from './components/passport/Clients.vue';
import AuthorizedClients from './components/passport/AuthorizedClients.vue';
import PersonalAccessTokens from './components/passport/PersonalAccessTokens.vue';

Vue.component('passport-clients',Client);

Vue.component('passport-authorized-clients', AuthorizedClients);

Vue.component('personal-access-tokens', PersonalAccessTokens);


const app = new Vue({
    el:'#root'
});
