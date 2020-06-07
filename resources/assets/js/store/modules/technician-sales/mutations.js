export default {
  SET_ALL_TECHNICIAN_SALES(state, allTechnicianSales) {
    state.allTechnicianSales = allTechnicianSales;
  },

  UPDATE_TECHNICIAN_SALES(state, technicianSales) {
    const technicianSale = technicianSales.sales[0];
    state.allTechnicianSales.sales = state.allTechnicianSales.sales.map(
      (technician) =>
        technician.technicianId === technicianSale.technicianId
          ? technicianSale
          : technician
    );
  },

  SET_DATE(state, date) {
    state.date = date;
  }
};
