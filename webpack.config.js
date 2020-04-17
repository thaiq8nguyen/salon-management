var path = require("path");

module.exports = {
  resolve: {
    extensions: [".js", ".vue", ".json"],
    alias: {
      Components: path.resolve(__dirname, "resources/assets/js/components"),
      Pages: path.resolve(__dirname, "resources/assets/js/pages"),
      State: path.resolve(__dirname, "resources/assets/js/state"),
      Plugins: path.resolve(__dirname, "resources/assetsjs/plugins"),
      Services: path.resolve(__dirname, "resources/assets/js/services")
    }
  }
};
