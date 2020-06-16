import Vue from "vue";
import Vuex from "vuex";
import "es6-promise/auto";
import createPersistedState from "vuex-persistedstate";
import getters from "./getters";
import actions from "./actions";
import mutations from "./mutations";
import Authentications from "./modules/authentications";
import Technicians from "./modules/technicians";
import TechnicianSales from "./modules/technician-sales";
import Payday from "./modules/payday";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    Authentications,
    Technicians,
    TechnicianSales,
    Payday
  },

  state: {
    paymentMethods: []
  },

  getters,
  actions,
  mutations,

  plugins: [createPersistedState()]
});
