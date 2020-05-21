import { authClient } from "Plugins/apiClient";

const getTechnicians = (id) => {
  return authClient.get(`/technicians/${id}`);
};
const addTechnician = (technician) => {
  return authClient.post("/technicians", technician);
};
const updateTechnician = (id, technician) => {
  return authClient.put(`/technicians/${id}`, technician);
};
const deleteTechnician = (id) => {
  return authClient.delete(`/technicians/${id}`);
};

export default {
  getTechnicians,
  addTechnician,
  updateTechnician,
  deleteTechnician
};
