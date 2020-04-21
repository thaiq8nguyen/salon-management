import Vue from "vue";
import AuthenticationServices from "Services/authenticationServices";

export default {
  login({ commit }, credential) {
    return new Promise((resolve, reject) => {
      return AuthenticationServices.login(credential)
        .then(response => {
          console.log(response.data)
          commit("SET_AUTHENTICATION", response.data);
          resolve();
      })
        .catch(errors => {
          if(errors.response){
            reject(errors.response)
          }
      })
    });
  }
};
