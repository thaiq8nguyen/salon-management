export default {
  SET_PAY_PERIODS(state, payPeriods) {
    state.payPeriods = payPeriods;
  },
  SET_PAY_PERIOD(state, payPeriodId) {
    let selectedIndex = state.payPeriods.findIndex(
      (payPeriod) => payPeriod.id === payPeriodId
    );
    state.selectedPayPeriod = state.payPeriods[selectedIndex];
  }
};
