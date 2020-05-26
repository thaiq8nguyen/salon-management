import { authClient } from "Services/apiClient";

const getTechnicianSales = (date) => {
  return authClient.get(`/sales/technicians?date=${date}`);
};

export default {
  getTechnicianSales
};
