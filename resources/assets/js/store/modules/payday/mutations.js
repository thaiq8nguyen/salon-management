import moment from "moment";

export default {
  SET_PAY_PERIODS(state, payPeriods) {
    state.payPeriods = payPeriods;
  },

  SET_PAY_PERIOD(state, payPeriodId) {
    let selectedIndex = state.payPeriods.findIndex(
      (payPeriod) => payPeriod.id === payPeriodId
    );
    state.selectedPayPeriod = state.payPeriods[selectedIndex];
  },

  SET_CURRENT_PAY_PERIOD(state) {
    const today = moment();
    state.selectedPayPeriod = state.payPeriods.filter((payPeriod) => {
      const beginDate = moment(payPeriod.beginDate);
      const payDate = moment(payPeriod.payDate);
      return beginDate.isSameOrBefore(today) && payDate.isSameOrAfter(today);
    })[0];
  },
  SET_ALL_TECHNICIAN_SALES(state, technicianSales) {
    state.technicianSales = technicianSales;
  },

  SET_ALL_TECHNICIAN_EARNINGS(state, allTechnicianEarnings) {
    state.technicianEarnings = allTechnicianEarnings;
  },

  SET_SELECTED_TECHNICIAN_ID(state, technicianId) {
    state.selectedTechnicianId = technicianId;
  }
};
