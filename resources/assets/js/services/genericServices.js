import { authClient } from "Services/apiClient";

const getAllPaymentMethods = () => {
  return authClient.get("/payment-methods");
};

export default {
  getAllPaymentMethods
};
