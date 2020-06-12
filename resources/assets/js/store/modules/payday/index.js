import getters from "./getters";
import actions from "./actions";
import mutations from "./mutations";

const state = {
  payPeriods: [],
  currentPayPeriod: null,
  technicianSales: [],
  technicianEarnings: []
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
