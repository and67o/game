const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const webpack = require('webpack');

const conf = {
	context: path.resolve(__dirname,'./js'),
	entry: {
		base: './base.js',
		gameField: './page/gameField/gameField.js',
		// gameField: './gameField.js',
	},
	output: {
		path: path.resolve(__dirname, './dist'),
		filename: '[name].js',
		publicPath: '/dist/',
	},
	devServer: {
		overlay: true
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: '/node_modules/',
				use: {
					loader: 'babel-loader',
					options: {
						presets: ['stage-0'],
					}
				}
			},
			{
				test: /\.(sa|sc|c)ss$/,
				use: [
					{
						loader: MiniCssExtractPlugin.loader,
						options: {
							hmr: process.env.NODE_ENV === 'development',
						},
					},
					'css-loader',
					'postcss-loader',
					'sass-loader',
				],
			},
		]
	},

	plugins: [
		new MiniCssExtractPlugin({
			filename: '[name].css',
		}),
		new webpack.ProvidePlugin({
			$: 'jquery',
			jQuery: 'jquery'
		}),
	]
};

module.exports = (env, options) => {
	const production = options.mode === 'production';
	conf.devtool = production
		? false
		: 'eval-sourcemap';
	return conf;
};
