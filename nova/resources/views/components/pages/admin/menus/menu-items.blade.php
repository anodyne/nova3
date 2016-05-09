<div class="page-header">
	<h1>Menu Items <small>{{ $menu->present()->name }}</small></h1>
</div>

<p>You can rearrange the order of menu items in this menu by dragging-and-dropping them into the order you want. You can also nest menu items underneath a top-level item by dragging it below and to the right of the item you want to nest it below.</p>

<div v-cloak>
	<mobile>
		@can('manage', $menu)
			<p><a href="{{ route('admin.menus') }}" class="btn btn-default btn-lg btn-block">{!! icon('arrow-back') !!}<span>Back to Menus</span></a></p>
		@endcan
		@can('create', $item)
			<p><a href="{{ route('admin.menus.items.create', [$menu->id]) }}" class="btn btn-success btn-lg btn-block">{!! icon('add') !!}<span>Add a Menu Item</span></a></p>
			<p><a href="#" class="btn btn-success btn-lg btn-block" data-menu="{{ $menu->id }}" @click.prevent="createItemDivider">{!! icon('add') !!}<span>Add a Divider</span></a></p>
		@endcan
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			@can('manage', $menu)
				<div class="btn-group">
					<a href="{{ route('admin.menus') }}" class="btn btn-default">{!! icon('arrow-back') !!}<span>Back to Menus</span></a>
				</div>
			@endcan
			@can('create', $item)
				<div class="btn-group">
					<a href="{{ route('admin.menus.items.create', [$menu->id]) }}" class="btn btn-success">{!! icon('add') !!}<span>Add a Menu Item</span></a>
				</div>
				<div class="btn-group">
					<a href="#" class="btn btn-default" data-menu="{{ $menu->id }}" @click.prevent="createItemDivider">{!! icon('add') !!}<span>Add a Divider</span></a>
				</div>
			@endcan
		</div>
	</desktop>

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
							<a href="#" class="danger" data-id="{{ $main->id }}" @click.prevent="removeMenuItem">{!! icon('delete', 'xs') !!}</a>
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
										<a href="#" class="danger" data-id="{{ $main->id }}" @click.prevent="removeMenuItem">{!! icon('delete', 'xs') !!}</a>
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
</div>