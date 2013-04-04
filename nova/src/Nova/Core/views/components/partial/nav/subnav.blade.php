<ul class="nav nav-list">
@foreach ($items as $item)
	@if ($item->order == 0 and $item->group != 0)
		<li class="divider"></li>
	@endif

	<?php $targetOutput = ($item->url_target == 'offsite') ? ' target="_blank"' : false;?>

	<li>{{ Html::link($item->url, $item->name) }}</li>
@endforeach
</ul>