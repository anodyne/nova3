<ul class="nav nav-{{ $style }}">
@foreach ($tabs as $tab)
	<li><a href="#{{ $tab->link_id }}" data-toggle="tab">{!! $tab->present()->name !!}</a></li>
@endforeach
</ul>