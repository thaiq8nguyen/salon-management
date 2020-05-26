import TechnicianSaleServices from "Services/technicianSaleServices";

export default {
  getTechnicianSales({ commit }, date) {
    console.log(date);
    return new Promise((resolve, reject) => {
      return TechnicianSaleServices.getTechnicianSales(date)
        .then((response) => {
          commit("SET_TECHNICIAN_SALES", response.data.technicianSales);
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
