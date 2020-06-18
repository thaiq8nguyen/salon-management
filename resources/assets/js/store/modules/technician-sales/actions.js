import TechnicianSaleServices from "Services/technicianSaleServices";

export default {
  getAllTechnicianSales({ commit }, date) {
    return new Promise((resolve, reject) => {
      return TechnicianSaleServices.getAllTechnicianSales(date)
        .then((response) => {
          commit(
            "SET_ALL_TECHNICIAN_SALES",
            response.data.allTechnicianSales.sales
          );
          commit("SET_DATE", response.data.allTechnicianSales.date);
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
          commit(
            "SET_ALL_TECHNICIAN_SALES",
            response.data.allTechnicianSales.sales
          );
          resolve();
        })
        .catch((errors) => {
          if (errors.response) {
            reject(errors);
          }
        });
    });
  },

  updateTechnicianSale({ commit }, sale) {
    return new Promise((resolve, reject) => {
      return TechnicianSaleServices.updateTechnicianSale(
        sale.transactionId,
        sale.amount
      )
        .then((response) => {
          commit(
            "UPDATE_TECHNICIAN_SALES",
            response.data.updateTechnicianSale.sales
          );
          resolve();
        })
        .catch((errors) => {
          if (errors.response) {
            reject(errors);
          }
        });
    });
  },

  deleteTechnicianSale({ commit }, saleId) {
    return new Promise((resolve, reject) => {
      return TechnicianSaleServices.deleteTechnicianSale(saleId)
        .then((response) => {
          commit(
            "UPDATE_TECHNICIAN_SALES",
            response.data.deleteTechnicianSale.sales
          );
          resolve();
        })
        .catch((errors) => {
          if (errors.response) {
            reject(errors);
          }
        });
    });
  },
  setDate({ commit }, date) {
    commit("SET_DATE", date);
  }
};
