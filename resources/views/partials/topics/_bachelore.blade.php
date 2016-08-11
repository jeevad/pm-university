<ul class="degree-list">
	{{ $i = 1 }} @foreach ($bacheoloreTopics as $bacheloreTopic)
	<li class="{{ $i === 1 ? 'active ' : ''}}degree-list-item"><i
		class="list-item-count">{{$i}}.</i>
		<p class="list-title">{{ link_to_action('TopicController@show', $bacheloreTopic->title, [$bacheloreTopic->slug])}}</p>
		<button>read</button></li> <?php $i++; ?>  @endforeach
</ul>