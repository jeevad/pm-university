<aside id="sidebar" class="sidebar c-overflow">
	<div class="s-profile">
		<a href="#" data-ma-action="profile-menu-toggle">
			<div class="sp-pic">
				<img src="{{ asset('assets/img/profile-pics/1.jpg') }}" alt="">
			</div>

			<div class="sp-info">
				{{ Auth::user()->full_name }} <i class="zmdi zmdi-caret-down"></i>
			</div>
		</a>

		<ul class="main-menu">
			<li><a href="profile-about.html"><i class="zmdi zmdi-account"></i>
					View Profile</a></li>
			<li><a href="#"><i class="zmdi zmdi-input-antenna"></i> Privacy
					Settings</a></li>
			<li><a href="#"><i class="zmdi zmdi-settings"></i> Settings</a></li>
			<li><a href="{{ url('/logout') }}"
				onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();"><i
					class="zmdi zmdi-time-restore"></i> Logout</a>
			<form id="logout-form" action="{{ url('/logout') }}" method="POST"
					style="display: none;">{{ csrf_field() }}</form></li>
		</ul>
	</div>

	<ul class="main-menu">
		<li class="active"><a href="index.html"><i class="zmdi zmdi-home"></i>
				Home</a></li>
		<li class="sub-menu"><a href="#" data-ma-action="submenu-toggle"><i
				class="zmdi zmdi-widgets"></i> Product types</a>

			<ul>
				<li><a href="/admin/product-types/bachelore">Bachelore</a></li>
				<li><a href="/admin/product-types/master">Master</a></li>
				<li><a href="/admin/product-types/specialization">Specialization</a></li>
			</ul></li>
		<li class="sub-menu"><a href="#" data-ma-action="submenu-toggle"><i
				class="zmdi zmdi-view-compact"></i> Topics</a>

			<ul>
				<li><a href="/admin/topics">List topics</a></li>
				<li><a href="/admin/topics/create">Add a topic</a></li>
			</ul></li>
		<li><a href="#"><i class="zmdi zmdi-format-underlined"></i> Users</a></li>

	</ul>
</aside>