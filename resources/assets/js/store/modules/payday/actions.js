import PaydayServices from "Services/paydayServices";

export default {
  getPayPeriods({ commit }) {
    return new Promise((resolve, reject) => {
      return PaydayServices.getStandardPayPeriods()
        .then((response) => {
          commit("SET_PAY_PERIODS", response.data.payPeriods);
          commit("SET_CURRENT_PAY_PERIOD");
          resolve();
        })
        .catch((errors) => {
          if (errors.response) {
            reject(errors);
          }
        });
    });
  },

  getTechnicianSales({ commit }, payPeriodId) {
    return new Promise((resolve, reject) => {
      return PaydayServices.getTechnicianSales(payPeriodId)
        .then((response) => {
          commit(
            "SET_TECHNICIAN_SALES",
            response.data.technicianSalesInPayPeriod
          );
        })
        .catch((errors) => {
          if (errors.response) {
            reject(errors);
          }
        });
    });
  },

  getTechnicianEarnings({ commit }, payPeriodId) {
    return new Promise((resolve, reject) => {
      return PaydayServices.getTechnicianEarnings(payPeriodId)
        .then((response) => {
          commit(
            "SET_ALL_TECHNICIAN_EARNINGS",
            response.data.technicianEarnings.technicians
          );
        })
        .catch((errors) => {
          if (errors.response) {
            reject(errors);
          }
        });
    });
  }
};
