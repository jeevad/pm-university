var elixir = require('laravel-elixir');

/*
 * |-------------------------------------------------------------------------- |
 * Elixir Asset Management
 * |-------------------------------------------------------------------------- | |
 * Elixir provides a clean, fluent API for defining some basic Gulp tasks | for
 * your Laravel application. By default, we are compiling the Sass | file for
 * our application, as well as publishing vendor resources. |
 */

elixir(function(mix) {
	// mix.sass('app.scss');
	mix.styles([ 'bootstrap.min.css' ], 'public/assets/css/vendor.css').styles(
			[ 'style.css' ], 'public/assets/css/app.css').scripts(
			[ 'vendor/jquery.min.js', 'vendor/bootstrap.min.js' ],
			'public/assets/js/vendor.js');

	mix.version([ 'assets/css/vendor.css', 'assets/css/app.css',
			'assets/js/vendor.js', 'assets/images' ]);
	mix.copy('resources/assets/images', 'public/build/assets/images');
	mix.copy('resources/assets/fonts', 'public/build/assets/fonts');
});