import AuthenticationServices from "Services/authenticationServices";

import router from "Router";

export default {
  login({ commit }, credential) {
    return new Promise((resolve, reject) => {
      return AuthenticationServices.login(credential)
        .then((response) => {
          commit("SET_AUTHENTICATION", response.data.user);
          resolve();
        })
        .catch((errors) => {
          if (errors.response) {
            reject(errors.response);
          }
        });
    });
  },
  logout({ dispatch }) {
    return AuthenticationServices.logout()
      .then(() => {
        router.push({ name: "Login" });
        dispatch("resetAuthentications");
      })
      .catch((errors) => {
        console.log(errors);
      });
  },
  resetAuthentications({ commit }) {
    commit("SET_AUTHENTICATION", {});
    this.removeState();
  }
};
