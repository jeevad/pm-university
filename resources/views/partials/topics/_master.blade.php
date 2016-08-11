<ul class="degree-list">
	{{ $i = 1 }} @foreach ($masterTopics as $masterTopic)
	<li class="{{ $i === 1 ? 'active ' : ''}}degree-list-item"><i
		class="list-item-count">{{$i}}.</i>
		<p class="list-title">{{ $masterTopic->title}}</p>
		<button>read</button></li>
	<?php $i++; ?>  @endforeach
</ul>