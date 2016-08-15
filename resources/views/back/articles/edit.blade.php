@extends('back.template') @section('content')
<div class="container">
	<div class="block-header">
		<h2>Edit an article</h2>
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
			<h2>{{ $article->title }}</h2>
		</div>
		@include('errors._form_errors')

		<div class="card-body card-padding">
			{!! Form::model($article, array('method' => 'PATCH','url' =>
			['admin/articles', 'id' => $article->id])) !!}
			{!! Form::hidden('topic_id', $article->topic_id) !!}
			@include('back.articles._form', ['submitButtonText' =>
			trans('messages.update_article')]) {!! Form::close() !!} <br /> <br />

		</div>
		<!-- Add Topic button -->
		@include('back.partials._add_button', ['url' => '/admin/articles/create?topicId='.$article->topic_id])
	</div>
</div>
@endsection

