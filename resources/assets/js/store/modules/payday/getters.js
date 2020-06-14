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

      return {
        firstName: technicianWithEarning.firstName,
        lastName: technicianWithEarning.lastName,
        fullName: technicianWithEarning.fullName,
        earning: technicianEarning
      };
    });
  }
};
