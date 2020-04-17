import apiClient from "./apiClient";
export default {
  install: function (Vue) {
    Vue.prototype.$apiClient = apiClient;
  }
};
