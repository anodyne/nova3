<div v-cloak>
	<phone-tablet>
		@can('create', $role)
			<p><a href="{{ route('admin.access.roles.create') }}" class="btn btn-success btn-lg btn-block">Add a Role</a></p>
		@endcan

		@can('manage', $permission)
			<p><a href="{{ route('admin.access.permissions') }}" class="btn btn-default btn-lg btn-block">Manage Permissions</a></p>
		@endcan
	</phone-tablet>
	<desktop>
		<div class="btn-toolbar">
			@can('create', $role)
				<div class="btn-group">
					<a href="{{ route('admin.access.roles.create') }}" class="btn btn-success">Add a Role</a>
				</div>
			@endcan

			@can('manage', $permission)
				<div class="btn-group">
					<a href="{{ route('admin.access.permissions') }}" class="btn btn-default">Manage Permissions</a>
				</div>
			@endcan
		</div>
	</desktop>
</div>

<div class="data-table data-table-striped data-table-bordered">
@foreach ($roles as $role)
	<div class="row">
		<div class="col-md-6">
			<p class="lead"><strong>{{ $role->present()->displayName }}</strong></p>
			<p><strong>Key:</strong> {{ $role->present()->key }}</p>

			@if ($role->users->count() > 0)
				<p class="text-muted text-sm"><em>{{ $role->present()->usersWithRole }}</em></p>
			@endif
		</div>
		<div class="col-md-6" v-cloak>
			<phone-tablet>
				<div class="row">
					@can('create', $role)
						<div class="col-xs-12">
							<p><a href="#" class="btn btn-default btn-lg btn-block js-roleAction" data-id="{{ $role->id }}" data-action="duplicate">Duplicate</a></p>
						</div>
					@endcan

					@can('edit', $role)
						<div class="col-xs-12">
							<p><a href="{{ route('admin.access.roles.edit', [$role->id]) }}" class="btn btn-default btn-lg btn-block">Edit</a></p>
						</div>

						@if ($role->users->count() > 0)
							<div class="col-xs-12">
								<p><a href="#" class="btn btn-default btn-lg btn-block">Users With This Role</a></p>
							</div>
						@endif
					@endcan

					@can('remove', $role)
						<div class="col-xs-12">
							<p><a href="#" class="btn btn-danger btn-lg btn-block js-roleAction" data-id="{{ $role->id }}" data-action="remove">Remove</a></p>
						</div>
					@endcan
				</div>
			</phone-tablet>
			<desktop>
				<div class="btn-toolbar pull-right">
					@can('create', $role)
						<div class="btn-group">
							<a href="#" class="btn btn-default js-roleAction" data-id="{{ $role->id }}" data-action="duplicate">Duplicate</a>
						</div>
					@endcan

					@can('edit', $role)
						<div class="btn-group">
							<a href="{{ route('admin.access.roles.edit', [$role->id]) }}" class="btn btn-default">Edit</a>
						</div>

						@if ($role->users->count() > 0)
							<div class="btn-group">
								<a href="#" class="btn btn-default">Users With This Role</a>
							</div>
						@endif
					@endcan

					@can('remove', $role)
						<div class="btn-group">
							<a href="#" class="btn btn-danger js-roleAction" data-id="{{ $role->id }}" data-action="remove">Remove</a>
						</div>
					@endcan
				</div>
			</desktop>
		</div>
	</div>
@endforeach
</div>

@can('remove', $role)
	{!! modal(['id' => "removeRole", 'header' => "Remove Role"]) !!}
@endcan

@can('create', $role)
	{!! modal(['id' => "duplicateRole", 'header' => "Duplicate Role"]) !!}
@endcan