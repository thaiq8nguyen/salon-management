import Vue from "vue";
import Plugins from "Plugins";

let Services = new Vue();
Vue.use(Plugins);

const addTechnicians = (technician) => {
  return Services.authClient.post("/technicians", technician);
};

export { addTechnicians };
