<div class="visible-xs visible-sm">
	<p><a href="{{ route('admin.menus.create') }}" class="btn btn-success btn-lg btn-block">Add New Menu</a></p>
</div>
<div class="visible-md visible-lg">
	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ route('admin.menus.create') }}" class="btn btn-success">Add New Menu</a>
		</div>
	</div>
</div>

<div class="data-table data-table-striped data-table-bordered">
@foreach ($menus as $menu)
	<div class="row">
		<div class="col-md-8">
			<p class="lead"><strong>{{ $menu->present()->name }}</strong></p>
			<p><strong>Key</strong>: {{ $menu->present()->key }}</p>
		</div>
		<div class="col-md-4">
			<div class="visible-xs visible-sm">
				<div class="row">
					<div class="col-xs-12 col-sm-6">
						<p><a href="{{ route('admin.menus.edit', [$menu->id]) }}" class="btn btn-default btn-lg btn-block">Edit</a></p>
					</div>
					<div class="col-xs-12 col-sm-6">
						<p><a href="{{ route('admin.menus.items', [$menu->id]) }}" class="btn btn-default btn-lg btn-block">Manage Items</a></p>
					</div>
					<div class="col-xs-12">
						<p><a href="#" class="btn btn-danger btn-lg btn-block js-menuAction" data-id="{{ $menu->id }}" data-action="remove">Remove</a></p>
					</div>
				</div>
			</div>
			<div class="visible-md visible-lg">
				<div class="btn-toolbar pull-right">
					<div class="btn-group">
						<a href="{{ route('admin.menus.edit', [$menu->id]) }}" class="btn btn-default">Edit</a>
						<a href="{{ route('admin.menus.items', [$menu->id]) }}" class="btn btn-default">Manage Items</a>
					</div>
					<div class="btn-group">
						<a href="#" class="btn btn-danger js-menuAction" data-id="{{ $menu->id }}" data-action="remove">Remove</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endforeach
</div>