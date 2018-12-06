const path = require('path');
const webpack = require('webpack');
const resolve = relativePath => path.resolve(__dirname, '..', relativePath);

const WebpackNotifierPlugin = require('webpack-notifier');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const FixStyleOnlyEntriesPlugin = require("webpack-fix-style-only-entries");
const VueLoaderPlugin = require('vue-loader/lib/plugin')

module.exports = {
    mode: 'development',
		devtool: 'eval',
	
    entry: {
				front: './assets/js/front.js',
				auth: './assets/js/auth.js'},
    
		output: {
        path: __dirname + '/public/build'},
    
		module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
                options: {
                  loaders: {
                    css: ['vue-style-loader', {loader: 'css-loader'}],
                    js: ['babel-loader']},
                  cacheBusting: true}},
            {
                test: /\.js$/,
                loader: 'babel-loader',
                include: [
                   // resolve('assets/js'),
                   resolve('node_modules/webpack-dev-server/client')],
            },
						{
                test: /\.(sa|sc|c)ss$/,
                use: [
									MiniCssExtractPlugin.loader, 
									'css-loader', 
									'sass-loader']
						},
						{
                test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
                use: [{
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: 'fonts/'
                    }
                }]
            }
        ]
    },
	
    plugins: [
				new FixStyleOnlyEntriesPlugin(),
        new WebpackNotifierPlugin({alwaysNotify: true}),
        new MiniCssExtractPlugin(),
				new VueLoaderPlugin()],
	
    resolve: {
        alias: { 'vue$': 'vue/dist/vue.esm.js' },
        extensions: [ '*', '.vue', '.js', '.json' ]},
	
};
