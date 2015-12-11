<ul class="nav nav-tabs">
@foreach ($tabs as $tab)
	<li><a href="#{{ $tab->link_id }}" data-toggle="tab">{!! $tab->present()->name !!}</a></li>
@endforeach
</ul>