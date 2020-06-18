export default {
  allTechnicianSales(state, getters, rootState, rootGetters) {
    const allTechnicians = rootGetters["Technicians/technicians"];

    return allTechnicians.map((technician) => {
      const technicianSale = state.allTechnicianSales.find(
        (technicianSale) =>
          technicianSale.technicianId === technician.technicianId
      );
      return {
        technicianId: technician.technicianId,
        fullName: technician.fullName,
        firstName: technician.firstName,
        lastName: technician.lastName,
        sales: technicianSale.sale
          ? {
              sale: technicianSale.sale,
              tip: technicianSale.tip
            }
          : null
      };
    });
  },
  date(state) {
    return state.date;
  }
};
