export default {
  SET_ALL_TECHNICIAN_SALES(state, allTechnicianSales) {
    state.allTechnicianSales = allTechnicianSales;
  },

  UPDATE_TECHNICIAN_SALES(state, technicianSale) {
    const sale = technicianSale.sales[0];
    state.allTechnicianSales.sales = state.allTechnicianSales.sales.map(
      (technician) =>
        technician.technicianId === sale.technicianId ? sale : technician
    );
  }
};
