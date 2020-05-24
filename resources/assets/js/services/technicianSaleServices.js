import { authClient } from "Services/apiClient";

const getTechnicianSales = (date) => {
  return authClient.get(`/technician-sales/date/${date}`);
};

export default {
  getTechnicianSales
};
