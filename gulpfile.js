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
	mix.styles([ 'bootstrap.min.css', 'style.css' ], 'public/assets/css')
			.scripts([ 'jquery.min.js', 'bootstrap.min.js' ],
					'public/assets/js');

	mix.version([ 'assets/css/all.css', 'assets/js/all.js', 'assets/images' ]);
	mix.copy('resources/assets/images', 'public/build/assets/images');
	mix.copy('resources/assets/fonts', 'public/build/assets/fonts');
});