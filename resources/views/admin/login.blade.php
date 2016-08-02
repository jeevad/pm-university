<!DOCTYPE html>
<html ng-app="myApp">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Material Admin</title>

<!-- Vendor CSS -->
<link
	href="{{ asset('')}}vendors/bower_components/animate.css/animate.min.css"
	rel="stylesheet">
<link
	href="{{ asset('')}}vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css"
	rel="stylesheet">

<!-- CSS -->
<link href="{{ asset('')}}css/app_1.min.css" rel="stylesheet">
<link href="{{ asset('')}}css/app_2.min.css" rel="stylesheet">
<script>
            window.globalConfig = {
                baseURL: "",
                siteURL: ""
            };
        </script>
</head>

<body ng-controller="authCtrl">
	<div class="login-content">
		<!-- Login -->
		<div class="lc-block toggled" id="l-login">
			<div class="lcb-form">
				<div class="alert alert-danger alert-dismissible" role="alert"
					ng-show="invalid_login">
					<button type="button" class="close" data-dismiss="alert"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<% invalid_login %>
				</div>
				<form name="loginForm" ng-submit="doLogin(login)" novalidate>
					{{ csrf_field()}}
					<div class="input-group m-b-20">
						<span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
						<div class="fg-line"
							ng-class="{'has-error': (loginForm.$submitted || loginForm.email.$touched) && loginForm.email.$invalid}">
							<input type="text" class="form-control" placeholder="Username"
								ng-model="login.email" name="email" ng-minlength="6"
								ng-maxlength="100"
								ng-pattern="/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/"
								required /> <span class="help-block"
								ng-show="(loginForm.$submitted || loginForm.email.$touched) && loginForm.email.$invalid">
								<span ng-show="loginForm.email.$error.required">Email field is
									required</span> <span ng-show="loginForm.email.$error.pattern">This
									is not a valid email.</span>
							</span>
						</div>
					</div>

					<div class="input-group m-b-20">
						<span class="input-group-addon"><i class="zmdi zmdi-male"></i></span>
						<div class="fg-line"
							ng-class="{ 'has-error': (loginForm.$submitted || loginForm.password.$touched) && loginForm.password.$invalid }">
							<input type="password" class="form-control"
								placeholder="{{trans('front/login.password')}}"
								ng-model="login.password" name="password" ng-minlength="6"
								ng-maxlength="30" required /> <span class="help-block"
								ng-show="(loginForm.$submitted || loginForm.password.$touched) && loginForm.password.$invalid">
								<span ng-show="loginForm.password.$error.required">Password
									field is required</span> <span
								ng-show="loginForm.password.$error.minlength">Password should
									have min 6 characters</span> <span
								ng-show="loginForm.password.$error.maxlength">Password should
									have max 30 characters<</span>
							</span>
						</div>
					</div>
					<div class="checkbox">
						<label> <input type="checkbox" value="" name="memory"
							ng-model="login.memory"> <i class="input-helper"></i> <!--                                Keep me signed in-->
							{{ trans('front/login.remind')}}
						</label>
					</div>
					<button type="submit" class="btn btn-login btn-success btn-float">
						<i class="zmdi zmdi-arrow-forward"></i>
					</button>
					<!--                        <a href="#" class="btn btn-login btn-success btn-float"><i class="zmdi zmdi-arrow-forward"></i></a>-->
				</form>

			</div>

			<div class="lcb-navigation">
				<a href="#" data-ma-action="login-switch"
					data-ma-block="#l-register"><i class="zmdi zmdi-plus"></i> <span>Register</span></a>
				<a href="#" data-ma-action="login-switch"
					data-ma-block="#l-forget-password"><i>?</i> <span>Forgot Password</span></a>
			</div>
		</div>

		<!-- Register -->
		<div class="lc-block" id="l-register">
			<div class="lcb-form">
				<div class="input-group m-b-20">
					<span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
					<div class="fg-line">
						<input type="text" class="form-control" placeholder="Username">
					</div>
				</div>

				<div class="input-group m-b-20">
					<span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
					<div class="fg-line">
						<input type="text" class="form-control"
							placeholder="Email Address">
					</div>
				</div>

				<div class="input-group m-b-20">
					<span class="input-group-addon"><i class="zmdi zmdi-male"></i></span>
					<div class="fg-line">
						<input type="password" class="form-control" placeholder="Password">
					</div>
				</div>

				<a href="#" class="btn btn-login btn-success btn-float"><i
					class="zmdi zmdi-check"></i></a>
			</div>

			<div class="lcb-navigation">
				<a href="#" data-ma-action="login-switch" data-ma-block="#l-login"><i
					class="zmdi zmdi-long-arrow-right"></i> <span>Sign in</span></a> <a
					href="#" data-ma-action="login-switch"
					data-ma-block="#l-forget-password"><i>?</i> <span>Forgot Password</span></a>
			</div>
		</div>

		<!-- Forgot Password -->
		<div class="lc-block" id="l-forget-password">
			<div class="lcb-form">
				<p class="text-left">Lorem ipsum dolor sit amet, consectetur
					adipiscing elit. Nulla eu risus. Curabitur commodo lorem fringilla
					enim feugiat commodo sed ac lacus.</p>

				<div class="input-group m-b-20">
					<span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
					<div class="fg-line">
						<input type="text" class="form-control"
							placeholder="Email Address">
					</div>
				</div>

				<a href="#" class="btn btn-login btn-success btn-float"><i
					class="zmdi zmdi-check"></i></a>
			</div>

			<div class="lcb-navigation">
				<a href="#" data-ma-action="login-switch" data-ma-block="#l-login"><i
					class="zmdi zmdi-long-arrow-right"></i> <span>Sign in</span></a> <a
					href="#" data-ma-action="login-switch" data-ma-block="#l-register"><i
					class="zmdi zmdi-plus"></i> <span>Register</span></a>
			</div>
		</div>
	</div>


	<!-- Older IE warning message -->
	<!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li>
                            <a href="http://www.google.com/chrome/">
                                <img src="img/browsers/chrome.png" alt="">
                                <div>Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.mozilla.org/en-US/firefox/new/">
                                <img src="img/browsers/firefox.png" alt="">
                                <div>Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com">
                                <img src="img/browsers/opera.png" alt="">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.apple.com/safari/">
                                <img src="img/browsers/safari.png" alt="">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                <img src="img/browsers/ie.png" alt="">
                                <div>IE (New)</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>
        <![endif]-->

	<!-- Javascript Libraries -->
	<script
		src="{{ asset('')}}vendors/bower_components/jquery/dist/jquery.min.js"></script>
	<script
		src="{{ asset('')}}vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script
		src="{{ asset('')}}vendors/bower_components/Waves/dist/waves.min.js"></script>

	<!-- Placeholder for IE9 -->
	<!--[if IE 9 ]>
            <script src="{{ asset('') }}vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js"></script>
        <![endif]-->

	<script src="{{ asset('')}}js/app.min.js"></script>
	<script src="{{ asset('')}}lib/angular.min.js"></script>
	<script src="{{ asset('')}}js/admin/app/controllers/authCtrl.js"></script>

</body>
</html>
