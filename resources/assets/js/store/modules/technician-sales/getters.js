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
        sales: technician.sale
          ? {
              sale: technicianSale.sale,
              tip: technicianSale.tip
            }
          : null
      };
    });

    //console.log(state.allTechnicianSales.sales);
  },
  date(state) {
    return state.date;
  }
};
