import getters from "./getters";
import actions from "./actions";
import mutations from "./mutaions";

const state = {
  authentication: "",
  authenticationErrors: ""
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
