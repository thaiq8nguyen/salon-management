import Vue from "vue";
import Vuex from "vuex";
import "es6-promise/auto";
import getters from "./getters";
import actions from "./actions";
import mutations from "./mutations";

import Authentications from "./modules/authentications";

import Persist from "Plugins/persistStates";

let Services = new Vue();

Vue.use(Persist);

const persistStates = (store) => {
  store.subscribe((mutation, state) => {
    Services.saveState(state);
  });
};

Vue.use(Vuex);

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
