import { authClient } from "Services/apiClient";

const getAllTechnicianSales = (date) => {
  return authClient.get(`/sales/technicians?date=${date}`);
};

const addTechnicianSale = (sale) => {
  return authClient.post("/sales/technicians", sale);
};

export default {
  getAllTechnicianSales,
  addTechnicianSale
};
