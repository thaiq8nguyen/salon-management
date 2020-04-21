import { client, authClient } from "./apiClient";
import { loadState, saveState, removeState } from "./persistStates";
export default {
  install: function (Vue) {
    Object.defineProperties(Vue.prototype, {
      client: {
        value: client
      },
      authClient: {
        value: authClient
      },
      loadState: {
        value: loadState
      },
      saveState: {
        value: saveState
      },
      removeState: {
        value: removeState
      }
    });
  }
};
