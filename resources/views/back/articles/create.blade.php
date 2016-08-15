@extends('back.template') @section('content')
<div class="container">
	<div class="block-header">
		<h2>Add Article</h2>
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
			<h2>
				Add a an article <small>Add quick, dynamic tab functionality to
					transition through panes of local content, even via dropdown menus.
				</small>
			</h2>
		</div>
		@include('errors._form_errors')

		<div class="card-body card-padding">
			{!! Form::open(array('url' => 'admin/articles')) !!}
			{!! Form::hidden('topic_id', $topicId) !!}
			@include('back.articles._form', ['submitButtonText' =>
			trans('messages.create_article')]) {!! Form::close() !!} <br /> <br />

		</div>
	</div>
</div>
@endsection

