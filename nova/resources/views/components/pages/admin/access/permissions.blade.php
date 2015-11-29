<div v-show="loading">
	<div v-show="!loadingWithError">
		<h4 class="text-center">{!! HTML::image('nova/resources/images/ajax-loader.gif') !!}</h4>
	</div>
	
	<div v-else v-cloak>
		{!! alert('danger', "There was an error retrieving your permissions from the database. This can be caused by a wrong URL or an issue with the database. Please try again.", "Error!") !!}
	</div>
</div>

<div v-else v-cloak>
	<phone-tablet>
		@if ($_user->can('access.create'))
			<p><a href="{{ route('admin.access.permissions.create') }}" class="btn btn-success btn-lg btn-block">Add a Permission</a></p>
		@endif

		<p><a href="{{ route('admin.access.roles') }}" class="btn btn-default btn-lg btn-block">Manage Roles</a></p>
	</phone-tablet>
	<desktop>
		<div class="btn-toolbar">
			@if ($_user->can('access.create'))
				<div class="btn-group">
					<a href="{{ route('admin.access.permissions.create') }}" class="btn btn-success">Add a Permission</a>
				</div>
			@endif

			<div class="btn-group">
				<a href="{{ route('admin.access.roles') }}" class="btn btn-default">Manage Roles</a>
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
					<phone-tablet>
						<a class="btn btn-default btn-lg btn-block" @click="resetFilters">Reset Filter</a>
					</phone-tablet>
					<desktop>
						<a class="btn btn-default btn-block" @click="resetFilters">Reset Filter</a>
					</desktop>
				</div>
			</div>
		</div>

		<div class="col-md-9 col-md-pull-3">
			<div class="data-table data-table-bordered data-table-striped">
				<div class="row" v-for="permission in permissions | filterBy search in 'display_name' 'name'">
					<div class="col-md-9">
						<p class="lead"><strong>@{{ permission.display_name }}</strong></p>
						<p><strong>Key:</strong> @{{ permission.name }}</p>
						<p v-show="permission.roles != ''"><strong>Included in Role(s):</strong> @{{! permission.roles !}}</p>
					</div>
					<div class="col-md-3" v-cloak>
						<phone-tablet>
							<div class="row">
								@if ($_user->can('access.edit'))
									<div class="col-sm-6">
										<p><a href="@{{ permission.links.edit }}" class="btn btn-default btn-lg btn-block">Edit</a></p>
									</div>
								@endif

								@if ($_user->can('access.remove'))
									<div class="col-sm-6" v-show="!permission.protected">
										<p><a href="#" class="btn btn-danger btn-lg btn-block" @click.prevent="removePermission(permission.id)">Remove</a></p>
									</div>
								@endif
							</div>
						</phone-tablet>
						<desktop>
							<div class="btn-toolbar pull-right">
								@if ($_user->can('access.edit'))
									<div class="btn-group">
										<a href="@{{ permission.links.edit }}" class="btn btn-default">Edit</a>
									</div>
								@endif

								@if ($_user->can('access.remove'))
									<div class="btn-group" v-show="!permission.protected">
										<a href="#" class="btn btn-danger" @click.prevent="removePermission(permission.id)">Remove</a>
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