<div class="page-header">
	<h1>Manage Menu Items <small>{{ $menu->present()->name }}</small></h1>
</div>

<div class="visible-xs visible-sm">
	<p><a href="#" class="btn btn-success btn-lg btn-block">Add Menu Item</a></p>
	<p><a href="{{ route('admin.menus') }}" class="btn btn-default btn-lg btn-block">Menu Manager</a></p>
</div>
<div class="visible-md visible-lg">
	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="#" class="btn btn-success">Add Menu Item</a>
		</div>
		<div class="btn-group">
			<a href="{{ route('admin.menus') }}" class="btn btn-default">Menu Manager</a>
		</div>
	</div>
</div>

<ul id="menu" data-menu="{{ $menu->id }}" class="list-unstyled uk-nestable" data-uk-nestable="{maxDepth:2}">
@foreach ($mainMenuItems as $main)
	<li data-id="{{ $main->id }}">
		<div class="uk-nestable-item">
			<div class="uk-nestable-handle"></div>
			<div data-nestable-action="toggle"></div>
			{{ $main->present()->title }}
			<div class="pull-right uk-nested-item-controls">
				<a href="#">{!! icon('edit', 'xs') !!}</a>
				<a href="#" class="danger">{!! icon('delete', 'xs') !!}</a>
			</div>
		</div>
		@if (array_key_exists($main->id, $subMenuItems))
			<ul>
			@foreach ($subMenuItems[$main->id] as $sub)
				<li data-id="{{ $sub->id }}">
					<div class="uk-nestable-item">
						<div class="uk-nestable-handle"></div>
						<div data-nestable-action="toggle"></div>
						{{ $sub->present()->title }}
						<div class="pull-right uk-nested-item-controls">
							<a href="#">{!! icon('edit', 'xs') !!}</a>
							<a href="#" class="danger">{!! icon('delete', 'xs') !!}</a>
						</div>
					</div>
				</li>
			@endforeach
			</ul>
		@endif
	</li>
@endforeach
</ul>