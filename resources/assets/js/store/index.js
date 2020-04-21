import Vue from "vue";
import Vuex from "vuex";
import "es6-promise/auto";
import getters from "./getters";
import actions from "./actions";
import mutations from "./mutations";

import Authentications from "./modules/authentications";

import Plugins from "Plugins";

let Services = new Vue();

Vue.use(Plugins);
Vue.use(Vuex);

const persistStates = (store) => {
  store.subscribe((mutation, state) => {
    Services.saveState(state);
  });
};

export default new Vuex.Store({
  modules: {
    Authentications
  },

  state: {},

  getters,
  actions,
  mutations,

  plugins: [persistStates]
});
