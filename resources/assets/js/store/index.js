import Vue from "vue";
import Vuex from "vuex";
import "es6-promise/auto";
import createPersistedState from "vuex-persistedstate";
import getters from "./getters";
import actions from "./actions";
import mutations from "./mutations";
import Authentications from "./modules/authentications";
import Technicians from "./modules/technicians";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    Authentications,
    Technicians
  },

  state: {},

  getters,
  actions,
  mutations,

  plugins: [createPersistedState()]
});
