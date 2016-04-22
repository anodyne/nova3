<div v-show="loading">
	<div v-if="!loadingWithError">
		<h4 class="text-center">{!! HTML::image('nova/resources/images/ajax-loader.gif') !!}</h4>
	</div>
	
	<div v-else v-cloak>
		{!! alert('danger', "There was an error retrieving your users from the database. This can be caused by a wrong URL or an issue with the database. Please try again.", "Error!") !!}
	</div>
</div>

<div v-else v-cloak>
	<mobile>
		@can('create', $user)
			<p><a href="{{ route('admin.users.create') }}" class="btn btn-success btn-lg btn-block">Add a User</a></p>
		@endcan
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			@can('create', $user)
				<div class="btn-group">
					<a href="{{ route('admin.users.create') }}" class="btn btn-success">Add a User</a>
				</div>
			@endcan
		</div>
	</desktop>

	<div class="row">
		<div class="col-md-3 col-md-push-9">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Filter Users</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="control-label">By Name, Character(s), or Email</label>
						{!! Form::text('searchName', null, ['class' => 'form-control', 'v-model' => 'search']) !!}
					</div>
					
					<div class="form-group">
						<label class="control-label">By Status</label>
						<div>
							<div class="checkbox">
								<label><input type="checkbox" value="{{ Status::toString(Status::ACTIVE) }}" v-model="statuses"> {{ ucwords(Status::toString(Status::ACTIVE)) }}</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="{{ Status::toString(Status::INACTIVE) }}" v-model="statuses"> {{ ucwords(Status::toString(Status::INACTIVE)) }}</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="{{ Status::toString(Status::PENDING) }}" v-model="statuses"> {{ ucwords(Status::toString(Status::PENDING)) }}</label>
							</div>
						</div>
					</div>
				</div>

				<div class="panel-footer">
					<mobile>
						<a class="btn btn-default btn-lg btn-block" @click="resetFilters">Reset Filters</a>
					</mobile>
					<desktop>
						<a class="btn btn-default btn-block" @click="resetFilters">Reset Filters</a>
					</desktop>
				</div>
			</div>
		</div>

		<div class="col-md-9 col-md-pull-3">
			<div class="data-table data-table-bordered data-table-striped">
				<div class="row" v-for="user in users | filterBy search in 'name' 'email' 'characters' | filterByCheckboxes statuses 'status'">
					<div class="col-md-9">
						<p class="lead"><strong>@{{ user.name }}</strong></p>
						<p><strong>Email Address:</strong> @{{ user.email }}</p>
						<p>@{{ user.status }}</p>
					</div>
					<div class="col-md-3">
						<mobile>
							<div class="row">
								@can('edit', $user)
									<div class="col-sm-6">
										<p><a href="@{{ user.links.edit }}" class="btn btn-default btn-lg btn-block">Edit</a></p>
									</div>
								@endcan

								@can('remove', $user)
									<div class="col-sm-6">
										<p><a href="#" class="btn btn-danger btn-lg btn-block" @click.prevent="removeUser(user.id)">Remove</a></p>
									</div>
								@endcan
							</div>
						</mobile>
						<desktop>
							<div class="btn-toolbar pull-right">
								@can('edit', $user)
									<div class="btn-group">
										<a href="@{{ user.links.edit }}" class="btn btn-default">Edit</a>
									</div>
								@endcan

								@can('remove', $user)
									<div class="btn-group">
										<a href="#" class="btn btn-danger" @click.prevent="removeUser(user.id)">Remove</a>
									</div>
								@endcan
							</div>
						</desktop>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@can('remove', $user)
	{!! modal(['id' => "removeUser", 'header' => "Remove User"]) !!}
@endcan