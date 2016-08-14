<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->

<!-- Mirrored from byrushan.com/projects/ma/1-6-1/jquery/light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Jun 2016 20:58:45 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Material Admin</title>


<!-- Vendor CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/vendor.css') }}">


<!-- CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

@yield('head')

</head>
<body>
	@include('back.partials._header')

	<section id="main">
		@include('back.partials._sidebar')


		@include('back.partials._chatsidebar')

		<section id="content">@include('flash::message') @yield('content')</section>
	</section>

	@include('back.partials._footer')

	<!-- Page Loader -->
	<div class="page-loader">
		<div class="preloader pls-blue">
			<svg class="pl-circular" viewBox="25 25 50 50">
                    <circle class="plc-path" cx="50" cy="50" r="20" />
                </svg>

			<p>Please wait...</p>
		</div>
	</div>

	<!-- Older IE warning message -->
	@include('back.partials._lt_ie_9')

	<!-- Javascript Libraries -->
	<script src="{{ elixir('assets/js/vendor.js') }}">
	</script>

	<!-- Placeholder for IE9 -->
	<!--[if IE 9 ]>
	<script src="{{ asset('assets/js/jquery.placeholder.min.js') }}">
	</script>
        <![endif]-->

	<script src="{{ elixir('assets/js/app.js') }}">
	</script>
	<script>
    $('#flash-overlay-modal').modal();
   // $('div.alert').not('.alert-important').delay(3000).fadeOut(550);
</script>


</body>

<!-- Mirrored from byrushan.com/projects/ma/1-6-1/jquery/light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Jun 2016 20:59:26 GMT -->
</html>
