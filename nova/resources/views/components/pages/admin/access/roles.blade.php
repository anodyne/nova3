<div v-cloak>
	<mobile>
		<div class="row">
			@can('create', $role)
				<div class="col-sm-6">
					<p><a href="{{ route('admin.access.roles.create') }}" class="btn btn-success btn-lg btn-block">{!! icon('add') !!}<span>Add a Role</span></a></p>
				</div>
			@endcan

			@can('manage', $permission)
				<div class="col-sm-6">
					<p><a href="{{ route('admin.access.permissions') }}" class="btn btn-secondary btn-lg btn-block">{!! icon('lock') !!}<span>Manage Permissions</span></a></p>
				</div>
			@endcan
		</div>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			@can('create', $role)
				<div class="btn-group">
					<a href="{{ route('admin.access.roles.create') }}" class="btn btn-success">{!! icon('add') !!}<span>Add a Role</span></a>
				</div>
			@endcan

			@can('manage', $permission)
				<div class="btn-group">
					<a href="{{ route('admin.access.permissions') }}" class="btn btn-secondary">{!! icon('lock') !!}<span>Manage Permissions</span></a>
				</div>
			@endcan
		</div>
	</desktop>
</div>

<div class="data-table data-table-striped data-table-bordered">
@foreach ($roles as $role)
	<div class="row">
		<div class="col-md-5 col-lg-6">
			<p class="lead"><strong>{{ $role->present()->name }}</strong></p>
			<p><strong>Key:</strong> {{ $role->present()->key }}</p>

			@if ($role->users->count() > 0)
				<p class="text-muted text-sm"><em>{{ $role->present()->usersWithRole }}</em></p>
			@endif
		</div>
		<div class="col-md-7 col-lg-6 controls" v-cloak>
			<mobile>
				<div class="row">
					@can('create', $role)
						<div class="col-xs-12">
							<p><a href="#" class="btn btn-secondary btn-lg btn-block" data-id="{{ $role->id }}" @click.prevent="duplicateRole">{!! icon('copy') !!}<span>Duplicate</span></a></p>
						</div>
					@endcan

					@can('edit', $role)
						<div class="col-xs-12">
							<p><a href="{{ route('admin.access.roles.edit', [$role->id]) }}" class="btn btn-secondary btn-lg btn-block">{!! icon('edit') !!}<span>Edit</span></a></p>
						</div>

						@if ($role->users->count() > 0)
							<div class="col-xs-12">
								<p><a href="#" class="btn btn-secondary btn-lg btn-block" data-id="{{ $role->id }}" @click.prevent="usersWithRole">{!! icon('users') !!}<span>Users With This Role</span></a></p>
							</div>
						@endif
					@endcan

					@can('remove', $role)
						<div class="col-xs-12">
							<p><a href="#" class="btn btn-danger btn-lg btn-block" data-id="{{ $role->id }}" @click.prevent="removeRole">{!! icon('delete') !!}<span>Remove</span></a></p>
						</div>
					@endcan
				</div>
			</mobile>
			<desktop>
				<div class="btn-toolbar pull-right">
					@can('create', $role)
						<div class="btn-group">
							<a href="#" class="btn btn-secondary" data-id="{{ $role->id }}" @click.prevent="duplicateRole">{!! icon('copy') !!}<span>Duplicate</span></a>
						</div>
					@endcan

					@can('edit', $role)
						<div class="btn-group">
							<a href="{{ route('admin.access.roles.edit', [$role->id]) }}" class="btn btn-secondary">{!! icon('edit') !!}<span>Edit</span></a>
						</div>

						@if ($role->users->count() > 0)
							<div class="btn-group">
								<a href="#" class="btn btn-secondary" data-id="{{ $role->id }}" @click.prevent="usersWithRole">{!! icon('users') !!}<span>Users With This Role</span></a>
							</div>
						@endif
					@endcan

					@can('remove', $role)
						<div class="btn-group">
							<a href="#" class="btn btn-danger" data-id="{{ $role->id }}" @click.prevent="removeRole">{!! icon('delete') !!}<span>Remove</span></a>
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

@can('edit', $role)
	{!! modal(['id' => "roleUsers", 'header' => "Users With Role"]) !!}
@endcan