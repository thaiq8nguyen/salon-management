import PaydayServices from "Services/paydayServices";

export default {
  getPayPeriods({ commit }) {
    return new Promise((resolve, reject) => {
      return PaydayServices.getStandardPayPeriods()
        .then((response) => {
          commit("SET_PAY_PERIODS", response.data.payPeriods);
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
