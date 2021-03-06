@extends('back.template') @section('content')
<div class="container">
	<div class="block-header">
		<h2>Topics</h2>
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
			<h2></h2>
		</div>

		<div class="card-body table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>Title</th>
						<th>Type</th>
						<th>Posted on</th>
						<th>Action</th>
						<th>Article</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($topics as $topic)
					<tr>
						<td>{{ $topic->id }}</td>
						<td>{{ $topic->title }}</td>
						<td>{{ $topic->level->title }}</td>
						<td>{{ $topic->created_at }}</td>
						<td><a href="topics/{{$topic->id}}/edit"
							class="btn btn-icon command-delete waves-effect waves-circle"><span
								class="zmdi zmdi-edit"></span></a>
							<form action="topics/{{ $topic->id }}" method="POST"
								style="display: inline">
								{{ method_field('DELETE') }} {{ csrf_field() }}
								<button type="submit"
									class="btn btn-icon command-delete waves-effect waves-circle">
									<span class="zmdi zmdi-delete"></span>
								</button>
							</form></td>
						<td><a href="/admin/articles/create?topicId={{$topic->id}}"
							class="btn btn-icon" title="Add an article"><span
								class="zmdi zmdi-plus-circle"></span></a> <a
							href="/admin/articles?topicId={{$topic->id}}"
							class="btn btn-icon" title="List all articles"><span
								class="zmdi zmdi-view-list-alt"></span></a></td>
					</tr>
					@endforeach
				</tbody>
			</table>

			<div id="data-table-command-footer"
				class="bootgrid-footer container-fluid">
				<div class="row">
					<div class="col-sm-6">{{ $topics->links() }}</div>
				</div>
			</div>
		</div>
		<!-- Add Topic button -->
		@include('back.partials._add_button', ['url' =>
		'/admin/topics/create'])
	</div>
</div>
@endsection
