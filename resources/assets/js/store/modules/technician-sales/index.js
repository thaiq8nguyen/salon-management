import actions from "./actions";
import getters from "./getters";
import mutations from "./mutations";

const state = {
  allTechnicianSales: [],
  date: new Date()
};

export default {
  namespaced: true,
  state,
  actions,
  getters,
  mutations
};
