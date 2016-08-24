@extends('back.template') @section('content')
<div class="container">
	<div class="block-header">
		<h2>Articles</h2>
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
			<h2>Topics Listing</h2>
		</div>

		<div class="card-body table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Title</th>

						<th>Posted on</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($articles as $article)
					<tr>
						<td>{{ $article->id }}</td>
						<td>{{ $article->title }}</td>
						<td>{{ $article->created_at }}</td>
						<td><a href="/admin/articles/{{$article->id}}/edit"
							class="btn btn-icon command-delete waves-effect waves-circle"><span
								class="zmdi zmdi-edit"></span></a>
							<form action="articles/{{ $article->id }}" method="POST"
								style="display: inline">
								{{ method_field('DELETE') }} {{ csrf_field() }}
								<button type="submit"
									class="btn btn-icon command-delete waves-effect waves-circle">
									<span class="zmdi zmdi-delete"></span>
								</button>
							</form></td>
					</tr>
					@endforeach
				</tbody>
			</table>

			<div id="data-table-command-footer"
				class="bootgrid-footer container-fluid">
				<div class="row">
					<div class="col-sm-6">{{ $articles->links() }}</div>
				</div>
			</div>
		</div>
		<!-- Add Topic button -->
		@include('back.partials._add_button', ['url' =>
		'/admin/articles/create?topicId='.$topicId])
	</div>
</div>
@endsection
