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

export default {
  getStandardPayPeriods,
  getCurrentPayPeriod,
  getTechnicianSales,
  getTechnicianEarnings
};
