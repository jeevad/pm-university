var elixir = require('laravel-elixir');

/*
 * |-------------------------------------------------------------------------- |
 * Elixir Asset Management
 * |-------------------------------------------------------------------------- | |
 * Elixir provides a clean, fluent API for defining some basic Gulp tasks | for
 * your Laravel application. By default, we are compiling the Sass | file for
 * our application, as well as publishing vendor resources. |
 */
var vendorDir = './resources/assets/vendor/';
var bowerDir = vendorDir + 'bower_components/';
var frontAssets = './resources/assets/front/';
elixir(function(mix) {
	// mix.sass('app.scss');

	mix.styles([ frontAssets + 'css/vendor/bootstrap.min.css' ],
			'public/assets/front/css/vendor.css').styles(
			[ frontAssets + 'css/style.css' ],
			'public/assets/front/css/app.css').scripts(
			[ frontAssets + 'js/vendor/jquery.min.js',
					frontAssets + 'js/vendor/bootstrap.min.js' ],
			'public/assets/front/js/vendor.js');

	/*
	 * mix.version([ 'assets/front/css/vendor.css', 'assets/front/css/app.css',
	 * 'assets/js/front/vendor.js' ]);
	 */
	mix.copy('resources/assets/front/images', 'public/assets/front/images');
	mix.copy('resources/assets/front/images', 'public/build/assets/front/images');
	mix.copy('resources/assets/front/fonts', 'public/assets/front/fonts');
	mix.copy('resources/assets/front/fonts', 'public/build/assets/front/fonts');
	/**
	 * Back end
	 */
	mix
			.styles(
					[
							bowerDir + 'fullcalendar/dist/fullcalendar.min.css',
							bowerDir + 'animate.css/animate.min.css',
							bowerDir + 'sweetalert/dist/sweetalert.css',
							bowerDir
									+ 'material-design-iconic-font/dist/css/material-design-iconic-font.min.css',
							bowerDir
									+ 'malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css',
							bowerDir + 'chosen/chosen.css' ],
					'public/assets/css/vendor.css')
			.styles([ 'app_1.min.css', 'app_2.min.css' ],
					'public/assets/css/app.css')
			.scripts(
					[
							bowerDir + 'jquery/dist/jquery.min.js',
							bowerDir + 'bootstrap/dist/js/bootstrap.min.js',
							bowerDir + 'flot/jquery.flot.js',
							bowerDir + 'flot/jquery.flot.resize.js',
							bowerDir + 'flot.curvedlines/curvedLines.js',
							vendorDir + 'sparklines/jquery.sparkline.min.js',
							bowerDir
									+ 'jquery.easy-pie-chart/dist/jquery.easypiechart.min.js',
							bowerDir + 'moment/min/moment.min.js',
							bowerDir + 'fullcalendar/dist/fullcalendar.min.js',
							bowerDir
									+ 'simpleWeather/jquery.simpleWeather.min.js',
							bowerDir + 'Waves/dist/waves.min.js',
							vendorDir
									+ 'bootstrap-growl/bootstrap-growl.min.js',
							bowerDir + 'sweetalert/dist/sweetalert.min.js',
							bowerDir
									+ 'malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js',
							bowerDir + 'chosen/chosen.jquery.js',
							'vendor/vue.min.js', 'vendor/vue-resource.min.js' ],
					'public/assets/js/vendor.js')

			.scripts([ 'app.min.js' ], 'public/assets/js/app.js')
			.copy(
					[ 'resources/assets/fonts',
							bowerDir + 'material-design-iconic-font/dist/fonts' ],
					'public/assets/fonts').copy('resources/assets/img',
					'public/assets/img').copy('resources/assets/media',
					'public/assets/media');
	mix.version([ 'assets/front/css/vendor.css', 'assets/front/css/app.css',
			'assets/front/js/vendor.js', 'assets/js/vendor.js',
			'public/assets/js/app.js' ]);

});