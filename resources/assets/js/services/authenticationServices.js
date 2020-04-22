import Vue from "vue";
import Plugins from "Plugins";

let Service = new Vue();
Vue.use(Plugins);

const login = (credential) => {
  return Service.client.post("/login", credential);
};

const register = (user) => {
  return Service.client.post("/register", user);
};
const logout = () => {
  return Service.authClient.post("/logout");
};

export default {
  login,
  register,
  logout
};
