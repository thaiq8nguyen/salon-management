export default {
  payPeriods(state) {
    return state.payPeriods.map((payPeriod) => {
      return {
        id: payPeriod.id,
        periodName: payPeriod.beginDate + " - " + payPeriod.endDate
      };
    });
    //return payPeriods;
  }
};
