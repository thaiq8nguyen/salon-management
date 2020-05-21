import moment from "moment";

export default {
  install: function (Vue) {
    Object.defineProperties(Vue.prototype, {
      $moment: {
        value: moment
      }
    });
  }
};
