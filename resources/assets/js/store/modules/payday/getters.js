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

  technicianEarnings(state, getters, rootState, rootGetters) {
    const allTechnicians = rootGetters["Technicians/technicians"];

    return state.technicianEarnings.map((technicianEarning) => {
      let technicianWithEarning = allTechnicians.find(
        (technician) =>
          technician.technicianId === technicianEarning.technicianId
      );
      const {
        technicianId,
        rates,
        saleWage,
        tipWage,
        totalSale,
        totalTip
      } = technicianEarning;
      return {
        firstName: technicianWithEarning.firstName,
        lastName: technicianWithEarning.lastName,
        fullName: technicianWithEarning.fullName,
        technicianId,
        earning: {
          rates,
          saleWage,
          tipWage,
          totalSale,
          totalTip
        }
      };
    });
  },

  selectedTechnician(state) {
    const earning = state.technicianEarnings.find(
      (technicianEarning) =>
        technicianEarning.technicianId === state.selectedTechnicianId
    );

    const sales = state.technicianSales.find(
      (technicianSale) =>
        technicianSale.technicianId === state.selectedTechnicianId
    );

    const formattedSales = groupBy(sales.sales, "date");

    return { earning, sales: formattedSales };
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
