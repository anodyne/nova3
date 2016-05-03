@can('create', $menu)
	<div v-cloak>
		<mobile>
			<p><a href="{{ route('admin.menus.create') }}" class="btn btn-success btn-lg btn-block">{!! icon('add') !!}<span>Add a Menu</span></a></p>
		</mobile>
		<desktop>
			<div class="btn-toolbar">
				<div class="btn-group">
					<a href="{{ route('admin.menus.create') }}" class="btn btn-success">{!! icon('add') !!}<span>Add a Menu</span></a>
				</div>
			</div>
		</desktop>
	</div>
@endcan

<div class="data-table data-table-striped data-table-bordered">
@foreach ($menus as $menu)
	<div class="row">
		<div class="col-md-6">
			<p class="lead"><strong>{{ $menu->present()->name }}</strong></p>
			<p><strong>Key</strong>: {{ $menu->present()->key }}</p>
		</div>
		<div class="col-md-6" v-cloak>
			<mobile>
				<div class="row">
					@can('edit', $menu)
						<div class="col-xs-12">
							<p><a href="{{ route('admin.menus.edit', [$menu->id]) }}" class="btn btn-default btn-lg btn-block">{!! icon('edit') !!}<span>Edit</span></a></p>
						</div>
					@endcan

					@can('manageMenuItems', $menu)
						<div class="col-xs-12 col-sm-6">
							<p><a href="{{ route('admin.menus.items', [$menu->id]) }}" class="btn btn-default btn-lg btn-block">Menu Items</a></p>
						</div>
					@endcan

					@can('manageMenuPages', $menu)
						<div class="col-xs-12 col-sm-6">
							<p><a href="{{ route('admin.menus.pages', [$menu->key]) }}" class="btn btn-default btn-lg btn-block">Pages Using this Menu</a></p>
						</div>
					@endcan

					@can('remove', $menu)
						<div class="col-xs-12">
							<p><a href="#" class="btn btn-danger btn-lg btn-block js-menuAction" data-id="{{ $menu->id }}" data-action="remove">{!! icon('delete') !!}<span>Remove</span></a></p>
						</div>
					@endcan
				</div>
			</mobile>
			<desktop>
				<div class="btn-toolbar pull-right">
					@can('edit', $menu)
						<div class="btn-group">
							<a href="{{ route('admin.menus.edit', [$menu->id]) }}" class="btn btn-default">{!! icon('edit') !!}<span>Edit</span></a>
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu dropdown-menu-right" role="menu">
								@can('manageMenuItems', $menu)
									<li><a href="{{ route('admin.menus.items', [$menu->id]) }}">Menu Items</a></li>
								@endcan
								
								@can('manageMenuPages', $menu)
									<li><a href="{{ route('admin.menus.pages', [$menu->key]) }}">Pages Using this Menu</a></li>
								@endcan
							</ul>
						</div>
					@endcan

					@can('remove', $menu)
						<div class="btn-group">
							<a href="#" class="btn btn-danger js-menuAction" data-id="{{ $menu->id }}" data-action="remove">{!! icon('delete') !!}<span>Remove</span></a>
						</div>
					@endcan
				</div>
			</desktop>
		</div>
	</div>
@endforeach
</div>

@can('remove', $menu)
	{!! modal(['id' => "removeMenu", 'header' => "Remove Menu"]) !!}
@endcan