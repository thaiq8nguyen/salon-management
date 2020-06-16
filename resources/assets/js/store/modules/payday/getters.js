import moment from "moment";
export default {
  payPeriods(state) {
    return state.payPeriods;
  },

  selectedPayPeriod(state) {
    return state.selectedPayPeriod;
  },

  technicianSales(state) {
    return state.technicianSales;
  },

  technicians(state, getters, rootState, rootGetters) {
    const allTechnicians = rootGetters["Technicians/technicians"];

    return allTechnicians.filter((technician) => {
      return state.technicianEarnings.some(
        (technicianEarning) =>
          technicianEarning.technicianId === technician.technicianId
      );
    });
  },

  selectedTechnician(state) {
    let technician = null;

    if (state.selectedTechnicianId) {
      const earning = state.technicianEarnings.find(
        (technicianEarning) =>
          technicianEarning.technicianId === state.selectedTechnicianId
      );

      const sales = state.technicianSales.find(
        (technicianSale) =>
          technicianSale.technicianId === state.selectedTechnicianId
      );

      const formattedSales = groupBy(sales.sales, "date");
      technician = { earning, sales: formattedSales };
    }
    return technician;
  },

  selectedTechnicianId(state) {
    return state.selectedTechnicianId;
  }
};

const groupBy = (array, key) => {
  const dates = array.reduce((result, currentValue) => {
    if (!result[currentValue[key]]) {
      result[currentValue[key]] = [];
    }
    result[currentValue[key]].push({
      amount: currentValue.creditAmount,
      name: currentValue.name,
      transactionId: currentValue.transactionId
    });
    return result;
  }, {});
  return Object.keys(dates).map((key) => {
    return {
      date: moment(key).format("ddd MM/DD/YYYY"),
      transactions: dates[key]
    };
  });
};
