import { authClient } from "Services/apiClient";

const getAllTechnicianSales = (date) => {
  return authClient.get(`/technicians/sales?date=${date}`);
};

const addTechnicianSales = (sales) => {
  return authClient.post("/technicians/sales", sales);
};

const updateTechnicianSale = (saleId, sale) => {
  return authClient.put(`/technicians/sales/${saleId}`, sale);
};

const deleteTechnicianSale = (saleId) => {
  return authClient.delete(`/technicians/sales/${saleId}`);
};

export default {
  getAllTechnicianSales,
  addTechnicianSales,
  updateTechnicianSale,
  deleteTechnicianSale
};
