<div class="list-group">
@foreach ($items as $item)
	{!! $item->present()->anchorTag(['class' => 'list-group-item']) !!}
@endforeach
</div>