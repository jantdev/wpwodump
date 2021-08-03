const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");
const UglifyJsPlugin = require("uglifyjs-webpack-plugin");
const OptimizeCssAssetsPlugin = require("optimize-css-assets-webpack-plugin");
var path = require("path");

// change these variables to fit your project
const jsPath = "js/mythemejs.js";
const cssPath = "css/mythemecss.css";
const devPath = path.resolve(__dirname, "../assets");
const phpPath = path.resolve(__dirname, "../");
const localDomain = "http://newjantdev.test";

module.exports = {
  entry: {
    app: ["./src/js/app.js", "./src/sass/app.scss"],
  },
  output: {
    path: devPath,
    filename: jsPath,
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: cssPath,
    }),

    new BrowserSyncPlugin({
      proxy: localDomain,
      files: [phpPath + "/**/*.php"],
    }),
  ],
  mode: "development",
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /(node_modules)/,
        use: {
          loader: "babel-loader",
          options: {
            presets: ["@babel/preset-env"],
          },
        },
      },
      {
        test: /\.s?[c]ss$/i,
        use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"],
      },
      {
        test: /\.sass$/i,
        use: [
          MiniCssExtractPlugin.loader,
          "css-loader",
          {
            loader: "sass-loader",
            options: {
              sassOptions: { indentedSyntax: true },
            },
          },
        ],
      },
      {
        test: /\.(jpg|jpeg|png|gif|woff|woff2|eot|ttf|svg)$/i,
        use: "url-loader?limit=1024",
      },
    ],
  },
  optimization: {
    minimizer: [new UglifyJsPlugin(), new OptimizeCssAssetsPlugin()],
  },
};
