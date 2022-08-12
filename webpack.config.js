const path = require("path");
const defaults = require("@wordpress/scripts/config/webpack.config");

module.exports = {
  ...defaults,
  entry: {
    admin: "./src/admin/",
    main: [
      "./src/main/index.js",
      "./src/main/fancybox.js",
      "./src/main/matchHeight.js",
    ],
    configurator: "./src/configurator/index.js",
  },
  output: {
    path: path.join(__dirname, "assets/js"),
    filename: "[name].js",
    chunkFilename: "[id].chunk.js",
  },
  externals: {
    react: "React",
    "react-dom": "ReactDOM",
  },
};
