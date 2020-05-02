import TechnicianServices from "Services/technicianServices";

export default {
  getTechnicians({ commit }, id = "") {
    return new Promise((resolve, reject) => {
      return TechnicianServices.getTechnicians(id)
        .then((response) => {
          commit("SET_TECHNICIANS", response.data.technicians);
          resolve();
        })
        .catch((errors) => {
          if (errors.response) {
            reject(errors);
          }
        });
    });
  },
  addTechnician({ commit }, technician) {
    return new Promise((resolve, reject) => {
      return TechnicianServices.addTechnician(technician)
        .then((response) => {
          commit("ADD_TECHNICIAN", response.data.technician);
          resolve();
        })
        .catch((errors) => {
          if (errors.response) {
            reject(errors);
          }
        });
    });
  },
  updateTechnician({ commit }, technician) {
    return new Promise((resolve, reject) => {
      return TechnicianServices.updateTechnician(technician.id, technician)
        .then((response) => {
          commit("UPDATE_TECHNICIAN", response.data.technician);
          resolve();
        })
        .catch((errors) => {
          if (errors.response) {
            reject(errors);
          }
        });
    });
  },
  deleteTechnician({ commit }, id) {
    return new Promise((resolve, reject) => {
      return TechnicianServices.deleteTechnician(id)
        .then((response) => {
          commit("DELETE_TECHNICIAN", id);
          resolve();
        })
        .catch((errors) => {
          if (errors.response) {
            reject(errors);
          }
        });
    });
  }
};
