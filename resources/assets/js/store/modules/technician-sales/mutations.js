export default {
  SET_ALL_TECHNICIAN_SALES(state, allTechnicianSales) {
    state.allTechnicianSales = allTechnicianSales;
  },

  UPDATE_TECHNICIAN_SALES(state, technicianSales) {
    console.log(technicianSales);
    state.allTechnicianSales = state.allTechnicianSales.map((technician) =>
      technician.technicianId === technicianSales.technicianId
        ? technicianSales
        : technician
    );
  },

  SET_DATE(state, date) {
    state.date = date;
  }
};
