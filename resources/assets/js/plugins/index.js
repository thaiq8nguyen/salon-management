import {client, authClient} from "./apiClient";
export default {
  install: function (Vue) {
    Object.defineProperties(Vue.prototype, {
      "client": {
        value: client
      }
    })
    //Vue.prototype.$client = client;
  }
};
