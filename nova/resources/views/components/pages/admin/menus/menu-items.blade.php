<div class="page-header">
	<h1>Manage Menu Items <small>{{ $menu->present()->name }}</small></h1>
</div>

<div class="visible-xs visible-sm">
	<p><a href="{{ route('admin.menus.items.create', [$menu->id]) }}" class="btn btn-success btn-lg btn-block">Add a Menu Item</a></p>
	<p><a href="#" class="btn btn-success btn-lg btn-block js-createMenuItemDivider" data-menu="{{ $menu->id }}">Add Divider</a></p>
	<p><a href="{{ route('admin.menus') }}" class="btn btn-default btn-lg btn-block">Menu Manager</a></p>
</div>
<div class="visible-md visible-lg">
	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ route('admin.menus.items.create', [$menu->id]) }}" class="btn btn-success">Add a Menu Item</a>
		</div>
		<div class="btn-group">
			<a href="#" class="btn btn-default js-createMenuItemDivider" data-menu="{{ $menu->id }}">Add Divider</a>
		</div>
		<div class="btn-group">
			<a href="{{ route('admin.menus') }}" class="btn btn-default">Menu Manager</a>
		</div>
	</div>
</div>

<ul id="menu" data-menu="{{ $menu->id }}" class="uk-nestable" data-uk-nestable="{maxDepth:2, handleClass:'uk-nestable-handle'}">
@foreach ($mainMenuItems as $main)
	<li data-id="{{ $main->id }}" class="uk-nestable-item">
		<div class="uk-nestable-panel">
			<div class="uk-nestable-handle uk-icon uk-icon-bars"></div>
			<div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
			@if ($main->type == 'divider')
				<span class="text-muted">(Item Divider)</span>
			@else
				{{ $main->present()->title }}
			@endif
			<div class="pull-right uk-nested-item-controls">
				<a href="{{ route('admin.menus.items.edit', [$main->id]) }}">{!! icon('edit', 'xs') !!}</a>
				<a href="#" class="danger js-menuItemAction" data-id="{{ $main->id }}" data-action="remove">{!! icon('delete', 'xs') !!}</a>
			</div>
		</div>
		@if (array_key_exists($main->id, $subMenuItems))
			<ul>
			@foreach ($subMenuItems[$main->id] as $sub)
				<li data-id="{{ $sub->id }}" class="uk-nestable-item">
					<div class="uk-nestable-panel">
						<div class="uk-nestable-handle uk-icon uk-icon-bars"></div>
						@if ($sub->type == 'divider')
							<span class="text-muted">(Item Divider)</span>
						@else
							{{ $sub->present()->title }}
						@endif
						<div class="pull-right uk-nested-item-controls">
							<a href="{{ route('admin.menus.items.edit', [$sub->id]) }}">{!! icon('edit', 'xs') !!}</a>
							<a href="#" class="danger js-menuItemAction" data-id="{{ $main->id }}" data-action="remove">{!! icon('delete', 'xs') !!}</a>
						</div>
					</div>
				</li>
			@endforeach
			</ul>
		@endif
	</li>
@endforeach
</ul>

{!! modal(['id' => "removeMenuItem", 'header' => "Remove Menu Item"]) !!}