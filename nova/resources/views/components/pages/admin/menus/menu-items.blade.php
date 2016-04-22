<div class="page-header">
	<h1>Menu Items <small>{{ $menu->present()->name }}</small></h1>
</div>

<p>You can rearrange the order of menu items in this menu by dragging-and-dropping them into the order you want. You can also nest menu items underneath a top-level item by dragging it below and to the right of the item you want to nest it below.</p>

<div v-cloak>
	<mobile>
		@can('create', $item)
			<p><a href="{{ route('admin.menus.items.create', [$menu->id]) }}" class="btn btn-success btn-lg btn-block">Add a Menu Item</a></p>
			<p><a href="#" class="btn btn-success btn-lg btn-block js-createMenuItemDivider" data-menu="{{ $menu->id }}">Add a Divider</a></p>
		@endcan

		@can('manage', $menu)
			<p><a href="{{ route('admin.menus') }}" class="btn btn-default btn-lg btn-block">Back to Menus</a></p>
		@endcan
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			@can('create', $item)
				<div class="btn-group">
					<a href="{{ route('admin.menus.items.create', [$menu->id]) }}" class="btn btn-success">Add a Menu Item</a>
				</div>
				<div class="btn-group">
					<a href="#" class="btn btn-default js-createMenuItemDivider" data-menu="{{ $menu->id }}">Add a Divider</a>
				</div>
			@endcan

			@can('manage', $menu)
				<div class="btn-group">
					<a href="{{ route('admin.menus') }}" class="btn btn-default">Back to Menus</a>
				</div>
			@endcan
		</div>
	</desktop>
</div>

@if ($mainMenuItems->count() > 0)
	<ul id="menu" data-menu="{{ $menu->id }}" class="uk-nestable" data-uk-nestable="{maxDepth:2, handleClass:'uk-nestable-handle'}">
	@foreach ($mainMenuItems as $main)
		<li data-id="{{ $main->id }}" class="uk-nestable-item">
			<div class="uk-nestable-panel">
				<div class="uk-nestable-handle uk-icon uk-icon-bars"></div>
				<div class="uk-nestable-toggle" data-nestable-action="toggle"></div>
				@if ($main->type == 'divider')
					<span class="text-muted">(Divider)</span>
				@else
					{{ $main->present()->title }}
				@endif
				<div class="pull-right uk-nested-item-controls">
					@can('edit', $main)
						<a href="{{ route('admin.menus.items.edit', [$main->id]) }}">{!! icon('edit', 'xs') !!}</a>
					@endcan

					@can('remove', $main)
						<a href="#" class="danger js-menuItemAction" data-id="{{ $main->id }}" data-action="remove">{!! icon('delete', 'xs') !!}</a>
					@endcan
				</div>
			</div>
			@if (array_key_exists($main->id, $subMenuItems))
				<ul>
				@foreach ($subMenuItems[$main->id] as $sub)
					<li data-id="{{ $sub->id }}" class="uk-nestable-item">
						<div class="uk-nestable-panel">
							<div class="uk-nestable-handle uk-icon uk-icon-bars"></div>
							@if ($sub->type == 'divider')
								<span class="text-muted">(Divider)</span>
							@else
								{{ $sub->present()->title }}
							@endif
							<div class="pull-right uk-nested-item-controls">
								@can('edit', $sub)
									<a href="{{ route('admin.menus.items.edit', [$sub->id]) }}">{!! icon('edit', 'xs') !!}</a>
								@endcan

								@can('remove', $sub)
									<a href="#" class="danger js-menuItemAction" data-id="{{ $main->id }}" data-action="remove">{!! icon('delete', 'xs') !!}</a>
								@endcan
							</div>
						</div>
					</li>
				@endforeach
				</ul>
			@endif
		</li>
	@endforeach
	</ul>
@else
	{!! alert('warning', "No menu items found.") !!}
@endif

@can('remove', $item)
	{!! modal(['id' => "removeMenuItem", 'header' => "Remove Menu Item"]) !!}
@endcan