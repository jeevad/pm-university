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
<link rel="stylesheet" href="{{ elixir('assets/css/vendor.css') }}">
<link rel="stylesheet" href="{{ elixir('assets/css/app.css') }}">
<script src="{{ elixir('assets/js/vendor.js') }}"></script>
</head>
<body>
	<header class="pmu-wrapper banner-wrapper">
		<div class="banner-container">
			<div class="banner-logo">
				<img src="{{ elixir('assets/images/logo.png') }}" title="Logo">
			</div>
			<div class="banner-title">Product Manager University</div>
			<div class="banner-desc">
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi
					eleifend ornare Aliquam gravida et elit sed vulputate pharetra
					mattis risus vehicula.</p>
			</div>
			<div class="banner-link">
				<i class="banner-arrow"></i>
			</div>
		</div>
	</header>

	<div class="pmu-container">
		<div class="bachelours-degree pmu-wrapper">
			<div class="bachelours-wrapper">
				<div class="bachelours-degree-wrapper">
					<div class="title pmu-title">BACHELOUR'S DEGREE</div>
					<div class="desc">Lorem ipsum dolor sit amet, consectetur
						adipiscing elit. Morbi eleifend ornare lorem. Aliquam gravida et
						elit sed vulputate</div>
					@include('partials.topics._bachelore');
				</div>
			</div>
		</div>
		<div class="masters-degree bachelours-degree pmu-wrapper">
			<div class="degree-wrapper">
				<div class="bachelours-degree-wrapper">
					<div class="title pmu-title">MASTER'S DEGREE</div>
					<div class="desc">Lorem ipsum dolor sit amet, consectetur
						adipiscing elit. Morbi eleifend ornare lorem. Aliquam gravida et
						elit sed vulputate</div>
					@include('partials.topics._master');
				</div>
			</div>
		</div>
		<div class="specialization pmu-wrapper">
			<div class="specialization-wrapper">
				<div class="title">Specialization</div>
				<div class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing
					elit. Morbi eleifend ornare Aliquam gravida et elit sed vulputate.</div>
				<ul class="specialization-list">
					<li class="specialization-list-item active"><i class="circle"></i>
						<span>Cro and Landing pages</span></li>
					<li class="specialization-list-item"><i class="circle"></i> <span>Analytics</span>
					</li>
					<li class="specialization-list-item"><i class="circle"></i> <span>A/B
							Testing</span></li>
					<li class="specialization-list-item"><i class="circle"></i> <span>A/B
							Testing</span></li>
					<li class="specialization-list-item"><i class="circle"></i> <span>Cro
							and Landing pages</span></li>
					<li class="specialization-list-item"><i class="circle"></i> <span>Analytics</span>
					</li>
					<li class="specialization-list-item"><i class="circle"></i> <span>A/B
							Testing</span></li>
					<li class="specialization-list-item"><i class="circle"></i> <span>A/B
							Testing</span></li>
				</ul>
			</div>
		</div>
		<div class="knowledge pmu-wrapper">
			<div class="knowledge-wrapper">
				<div class="title">Halls of Knowledge</div>
				<div class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing
					elit. Morbi eleifend ornare Aliquam gravida et elit sed vulputate.</div>
				<div class="knowledge-list">
					<div class="knowledge-list-item active">
						<div class="list-image">
							<img src="./assets/images/knowledge-class.png" />
						</div>
						<div class="list-desc">
							<p>Product Manager Courses</p>
						</div>
					</div>
					<div class="knowledge-list-item">
						<div class="list-image">
							<img src="./assets/images/knowledge-pen.png" />
						</div>
						<div class="list-desc">
							<p>Product Manager Blogs</p>
						</div>
					</div>
					<div class="knowledge-list-item">
						<div class="list-image">
							<img src="./assets/images/knowledge-earpod.png" />
						</div>
						<div class="list-desc">
							<p>Product Manager Podcasts</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="placements pmu-wrapper">
			<div class="placements-wrapper">
				<div class="title">Placements</div>
				<div class="desc">Lorem ipsum dolor sit amet, consectetur adipiscing
					elit. Morbi eleifend ornare Aliquam gravida et elit sed vulputate.</div>
				<div class="placements-list">
					<div class="placements-list-item">
						<div class="list-image">
							<img src="./assets/images/pm-interviews.png" />
						</div>
						<div class="list-content">
							<div class="list-header title">Product Managment jobs</div>
							<div class="list-desc desc">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
									Morbi eleifend ornare lorem. Aliquam gravida et elit sed
									vulputate.</p>
							</div>
							<div class="list-link">
								<a href="javascript:void()">Read more </a>
							</div>
						</div>
					</div>
					<div class="placements-list-item">
						<div class="list-image">
							<img src="./assets/images/pm-jobs.png" />
						</div>
						<div class="list-content">
							<div class="list-header title">Product Managment jobs</div>
							<div class="list-desc desc">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
									Morbi eleifend ornare lorem. Aliquam gravida et elit sed
									vulputate.</p>
							</div>
							<div class="list-link">
								<a href="javascript:void()">Read more </a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>