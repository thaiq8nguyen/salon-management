import TechnicianSaleServices from "Services/technicianSaleServices";

export default {
  getAllTechnicianSales({ commit }, date) {
    return new Promise((resolve, reject) => {
      return TechnicianSaleServices.getAllTechnicianSales(date)
        .then((response) => {
          commit("SET_ALL_TECHNICIAN_SALES", response.data.allTechnicianSales);
          resolve();
        })
        .catch((errors) => {
          if (errors.response) {
            reject(errors);
          }
        });
    });
  },

  addTechnicianSale({ commit }, sale) {
    return new Promise((resolve, reject) => {
      return TechnicianSaleServices.addTechnicianSales(sale)
        .then((response) => {
          commit("SET_ALL_TECHNICIAN_SALES", response.data.allTechnicianSales);
        })
        .catch((errors) => {
          if (errors.response) {
            reject(errors);
          }
        });
    });
  }
};
