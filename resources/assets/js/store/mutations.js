import Vue from "vue";
import Plugins from "Plugins";

const Services = new Vue();
Vue.use(Plugins);

export default {
  INITIALIZE_STATE(state) {
    if (Services.loadState()) {
      this.replaceState(Object.assign(state, Services.loadState()));
    }
  }
};
