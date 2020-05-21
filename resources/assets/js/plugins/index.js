import moment from "moment";
export default {
  install(Vue, options) {
    Vue.prototype.$moment = moment;
  }
};
