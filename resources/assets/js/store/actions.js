import genericServices from "Services/genericServices";
export default {
  async init({ commit }) {
    const paymentMethods = await getAllPaymentMethods();
    commit("SET_PAYMENT_METHODS", paymentMethods);
  }
};

function getAllPaymentMethods() {
  return new Promise((resolve, reject) => {
    return genericServices
      .getAllPaymentMethods()
      .then((response) => {
        resolve(response.data.paymentMethods);
      })
      .catch((errors) => {
        if (errors.response) {
          reject(errors);
        }
      });
  });
}
