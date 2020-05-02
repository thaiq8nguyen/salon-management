import Vue from "vue";
import Plugins from "Plugins";

let Services = new Vue();
Vue.use(Plugins);

const getTechnicians = (id) => {
  return Services.authClient.get(`/technicians/${id}`);
};
const addTechnician = (technician) => {
  return Services.authClient.post("/technicians", technician);
};
const updateTechnician = (id, technician) => {
  return Services.authClient.put(`/technicians/${id}`, technician);
};
const deleteTechnician = (id) => {
  return Services.authClient.delete(`/technicians/${id}`);
};

export default {
  getTechnicians,
  addTechnician,
  updateTechnician,
  deleteTechnician
};
