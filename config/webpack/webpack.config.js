const path = require("path");
const webpack = require("webpack");
const resolve = relativePath => path.resolve(__dirname, "..", relativePath);
const WebpackNotifierPlugin = require("webpack-notifier");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const VueLoaderPlugin = require("vue-loader/lib/plugin");
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const ManifestPlugin = require('webpack-manifest-plugin');

module.exports = {
  entry: {
    front: "./assets/js/front.js",
    auth: "./assets/js/auth.js",
    dash: "./assets/js/dash.js"
  },

  output: {
    path: __dirname + "./../../public/assets/",
    filename: '[name].[contenthash].js'     
  },

  module: {
    rules: [
      {
        test: /\.vue$/,
        loader: "vue-loader",
        options: {
          loaders: {
            css: ["vue-style-loader", { loader: "css-loader" }],
            js: ["babel-loader"]
          }
        }
      },

      { test: /\.js$/, loader: "babel-loader" },

      {
        test: /\.(sa|sc|c)ss$/,
        use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"]
      },

      {
        test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
        loader: "file-loader",
        options: {
          name: "[name].[ext]",
          outputPath: "../fonts/"
        }
      }
    ]
  },
   optimization: {
    runtimeChunk: 'single'
  },
  plugins: [
    new WebpackNotifierPlugin({ alwaysNotify: true }),
    new MiniCssExtractPlugin({
      filename: '[name].[contenthash].css',
      chunkFilename: '[name].[contenthash].css'
    }),
    new VueLoaderPlugin(),
    new CleanWebpackPlugin(),
    new ManifestPlugin({
      basePath: '/assets/',
      publicPath: '/assets/'
    })
  ],

  resolve: {
    alias: { vue$: "vue/dist/vue.esm.js" },
    extensions: ["*", ".vue", ".js", ".json"]
  }
};
