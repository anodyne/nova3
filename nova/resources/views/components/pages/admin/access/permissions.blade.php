<div v-cloak>
	<mobile>
		@if ($_user->can('access.create'))
			<p><a href="{{ route('admin.access.permissions.create') }}" class="btn btn-success btn-lg btn-block">{!! icon('add') !!}<span>Add a Permission</span></a></p>
		@endif

		<p><a href="{{ route('admin.access.roles') }}" class="btn btn-default btn-lg btn-block">{!! icon('lock') !!}<span>Manage Roles</span></a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			@if ($_user->can('access.create'))
				<div class="btn-group">
					<a href="{{ route('admin.access.permissions.create') }}" class="btn btn-success">{!! icon('add') !!}<span>Add a Permission</span></a>
				</div>
			@endif

			<div class="btn-group">
				<a href="{{ route('admin.access.roles') }}" class="btn btn-default">{!! icon('lock') !!}<span>Manage Roles</span></a>
			</div>
		</div>
	</desktop>

	<div class="row">
		<div class="col-md-3 col-md-push-9">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Filter Permissions</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="control-label">By Name/Key</label>
						{!! Form::text('searchName', null, ['class' => 'form-control', 'v-model' => 'search']) !!}
					</div>
				</div>

				<div class="panel-footer" v-cloak>
					<mobile>
						<a class="btn btn-default btn-lg btn-block" @click="resetFilters">Reset Filter</a>
					</mobile>
					<desktop>
						<a class="btn btn-default btn-block" @click="resetFilters">Reset Filter</a>
					</desktop>
				</div>
			</div>
		</div>

		<div class="col-md-9 col-md-pull-3">
			<div class="data-table data-table-bordered data-table-striped">
				<div class="row" v-for="permission in permissions | filterBy search in 'name' 'key'">
					<div class="col-md-9">
						<p class="lead"><strong>@{{ permission.name }}</strong></p>
						<p><strong>Key:</strong> @{{ permission.key }}</p>
						<p v-show="permission.roles.length > 0"><strong>Included in Role(s):</strong> @{{ permissionRoles(permission.roles) }}</p>
					</div>
					<div class="col-md-3" v-cloak>
						<mobile>
							<div class="row">
								@if ($_user->can('access.edit'))
									<div class="col-sm-6">
										<p><a href="@{{ permission.editUrl }}" class="btn btn-default btn-lg btn-block">{!! icon('edit') !!}<span>Edit</span></a></p>
									</div>
								@endif

								@if ($_user->can('access.remove'))
									<div class="col-sm-6" v-show="!permission.isProtected">
										<p><a href="#" class="btn btn-danger btn-lg btn-block" @click.prevent="removePermission(permission.id)">{!! icon('delete') !!}<span>Remove</span></a></p>
									</div>
								@endif
							</div>
						</mobile>
						<desktop>
							<div class="btn-toolbar pull-right">
								@if ($_user->can('access.edit'))
									<div class="btn-group">
										<a href="@{{ permission.editUrl }}" class="btn btn-default">{!! icon('edit') !!}<span>Edit</span></a>
									</div>
								@endif

								@if ($_user->can('access.remove'))
									<div class="btn-group" v-show="!permission.isProtected">
										<a href="#" class="btn btn-danger" @click.prevent="removePermission(permission.id)">{!! icon('delete') !!}<span>Remove</span></a>
									</div>
								@endif
							</div>
						</desktop>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@if ($_user->can('access.remove'))
	{!! modal(['id' => "removePermission", 'header' => "Remove Permission"]) !!}
@endif