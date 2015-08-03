<div class="visible-xs visible-sm">
	@if ($_user->can('access.create'))
		<p><a href="{{ route('admin.access.roles.create') }}" class="btn btn-success btn-lg btn-block">Add a Role</a></p>
	@endif

	<p><a href="{{ route('admin.access.permissions') }}" class="btn btn-default btn-lg btn-block">Manage Role Permissions</a></p>
</div>
<div class="visible-md visible-lg">
	<div class="btn-toolbar">
		@if ($_user->can('access.create'))
			<div class="btn-group">
				<a href="{{ route('admin.access.roles.create') }}" class="btn btn-success">Add a Role</a>
			</div>
		@endif

		<div class="btn-group">
			<a href="{{ route('admin.access.permissions') }}" class="btn btn-default">Manage Role Permissions</a>
		</div>
	</div>
</div>

<div class="data-table data-table-striped data-table-bordered">
@foreach ($roles as $role)
	<div class="row">
		<div class="col-md-6">
			<p class="lead"><strong>{{ $role->present()->name }}</strong></p>

			@if ($role->users->count() > 0)
				<p class="text-muted text-sm"><em>{{ $role->present()->usersWithRole }}</em></p>
			@endif
		</div>
		<div class="col-md-6">
			<div class="visible-xs visible-sm">
				<div class="row">
					@if ($_user->can('access.edit'))
						<div class="col-xs-12">
							<p><a href="{{ route('admin.access.roles.edit', [$role->id]) }}" class="btn btn-default btn-lg btn-block">Edit</a></p>
						</div>
						<div class="col-xs-12">
							<p><a href="#" class="btn btn-default btn-lg btn-block">Users With This Role</a></p>
						</div>
					@endif

					@if ($_user->can('access.remove'))
						<div class="col-xs-12">
							<p><a href="#" class="btn btn-danger btn-lg btn-block js-roleAction" data-id="{{ $role->id }}" data-action="remove">Remove</a></p>
						</div>
					@endif
				</div>
			</div>
			<div class="visible-md visible-lg">
				<div class="btn-toolbar pull-right">
					@if ($_user->can('access.edit'))
						<div class="btn-group">
							<a href="{{ route('admin.access.roles.edit', [$role->id]) }}" class="btn btn-default">Edit</a>
						</div>
						<div class="btn-group">
							<a href="#" class="btn btn-default">Users With This Role</a>
						</div>
					@endif

					@if ($_user->can('access.remove'))
						<div class="btn-group">
							<a href="#" class="btn btn-danger js-roleAction" data-id="{{ $role->id }}" data-action="remove">Remove</a>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endforeach
</div>

@if ($_user->can('access.remove'))
	{!! modal(['id' => "removeRole", 'header' => "Remove Access Role"]) !!}
@endif