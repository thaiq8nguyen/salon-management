import { authClient } from "Services/apiClient";

const getTechnicianSales = (date) => {
  return authClient.get();
};
