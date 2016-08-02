@extends('layouts.app') @section('content')
<div class="error-page">
	<h2 class="headline text-info">500</h2>
	<div class="error-content">
		<h3>
			<i class="fa fa-warning text-yellow"></i> Oops! looks like something
			went wrong.
		</h3>
		<p>
			Sorry for inconvenience Meanwhile, you may <a href="{{ url('')}}">return
				to Home page</a> or try using the search form.
		</p>
	</div>
</div>
@endsection
