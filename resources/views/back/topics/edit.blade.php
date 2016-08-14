@extends('back.template') @section('content')
<div class="container">
	<div class="block-header">
		<h2>Edit topic</h2>
		<ul class="actions">
			<li><a href="#"> <i class="zmdi zmdi-trending-up"></i>
			</a></li>
			<li><a href="#"> <i class="zmdi zmdi-check-all"></i>
			</a></li>
			<li class="dropdown"><a href="#" data-toggle="dropdown"> <i
					class="zmdi zmdi-more-vert"></i>
			</a>

				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="#">Refresh</a></li>
					<li><a href="#">Manage Widgets</a></li>
					<li><a href="#">Widgets Settings</a></li>
				</ul></li>
		</ul>

	</div>
	<div class="card">
		<div class="card-header">
			<h2>{{ $topic->title }}</h2>
		</div>
		@include('errors._form_errors')

		<div class="card-body card-padding">
			{!! Form::model($topic, array('method' => 'PATCH','url' =>
			['admin/topics', 'id' => $topic->id])) !!}
			@include('back.topics._form', ['submitButtonText' =>
			trans('messages.update_topic')]) {!! Form::close() !!} <br /> <br />

		</div>
		<!-- Add Topic button -->
		@include('back.partials._add_button', ['url' => '/admin/topics/create'])
	</div>
</div>
@endsection

