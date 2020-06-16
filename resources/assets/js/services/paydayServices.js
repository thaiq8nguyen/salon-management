import { authClient } from "Services/apiClient";

const getStandardPayPeriods = () => {
  return authClient.get("/pay-periods?query=standard");
};

const getCurrentPayPeriod = () => {
  return authClient.get("/pay-periods?query=current");
};

const getTechnicianSales = (payPeriodId) => {
  return authClient.get(`/pay-periods/${payPeriodId}/technicians/sales`);
};

const getTechnicianEarnings = (payPeriodId) => {
  return authClient.get(`/pay-periods/${payPeriodId}/technicians/earnings`);
};

const makePayments = (payPeriodId, payments) => {
  return authClient.post(
    `/pay-periods/${payPeriodId}/technicians/payments`,
    payments
  );
};

export default {
  getStandardPayPeriods,
  getCurrentPayPeriod,
  getTechnicianSales,
  getTechnicianEarnings,
  makePayments
};
