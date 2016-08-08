<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible"
	content="IE=11; IE=10; IE=9; IE=8; IE=EDGE">
<meta charset="utf-8" />
<title>{{config('globals.site_title_abbr') }} | {{
	config('globals.site_title') }}</title>
<link rel="stylesheet" href="{{ elixir('assets/css/all.css') }}">
<script src="{{ elixir('assets/js/all.js') }}"></script>
</head>
<body>
	<header class="image-bg-fluid-height pmu-wrapper banner-wrapper">
		<div class="banner-container">
			<div class="banner-logo">
				<img src="{{ elixir('assets/images/logo.png') }}" title="Logo">
			</div>
			<div class="banner-title pmu-title">Product Manager University</div>
			<div class="banner-desc pmu-desc">
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi
					eleifend ornare Aliquam gravida et elit sed vulputate pharetra
					mattis risus vehicula.</p>
			</div>
			<div class="banner-link">
				<i class="banner-arrow"></i>
			</div>
		</div>
	</header>
	<div class="bachelours-degree pmu-wrapper">
		<div class="bachelours-degree-wrapper">
			<div class="title pmu-title">BACHELOUR’S DEGREE</div>
			<div class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing
				elit. Morbi eleifend ornare lorem. Aliquam gravida et elit sed
				vulputate</div>
			<ul class="degree-list">
				<li class="active degree-list-item"><i class="list-item-count">1.</i>
					<p class="list-title">What is Product Management?</p>
					<button>read</button></li>
				<li class="degree-list-item"><i class="list-item-count">2.</i>
					<p class="list-title">Working with and managing Product Teams</p>
					<button>read</button></li>
				<li class="degree-list-item"><i class="list-item-count">3.</i>
					<p class="list-title">How to build great products?</p>
					<button>read</button></li>
				<li class="degree-list-item"><i class="list-item-count">4.</i>
					<p class="list-title">Which features/product to build?</p>
					<button>read</button></li>
				<li class="degree-list-item"><i class="list-item-count">5.</i>
					<p class="list-title">Ship and measure : Matrix that matter</p>
					<button>read</button></li>
			</ul>
		</div>
	</div>
</body>
</html>