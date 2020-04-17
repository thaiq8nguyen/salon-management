var path = require("path");

module.exports = {
  resolve: {
    extensions: [".js", ".vue", ".json"],
    alias: {
      Components: path.resolve(__dirname, "resources/assets/js/components"),
      Pages: path.resolve(__dirname, "resources/assets/js/pages"),
      Store: path.resolve(__dirname, "resources/assets/js/store"),
      Plugins: path.resolve(__dirname, "resources/assets/js/plugins"),
      Services: path.resolve(__dirname, "resources/assets/js/services")
    }
  }
};
