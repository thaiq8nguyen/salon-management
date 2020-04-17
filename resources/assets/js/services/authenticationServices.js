import Vue from "vue";
import apiClient from "Plugins/apiClient";

let Service = new Vue();
Vue.use(apiClient);

const login = (credential) => {
  return Service.client.post("/login", credential);
};

const register = (user) => {
  return Service.client.post("/register", user);
};

export default {
  login,
  register
};
