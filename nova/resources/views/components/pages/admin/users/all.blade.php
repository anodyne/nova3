<div v-cloak>
	<mobile>
		@can('create', $user)
			<p><a href="{{ route('admin.users.create') }}" class="btn btn-success btn-lg btn-block">{!! icon('add') !!}<span>Add a User</span></a></p>
		@endcan
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			@can('create', $user)
				<div class="btn-group">
					<a href="{{ route('admin.users.create') }}" class="btn btn-success">{!! icon('add') !!}<span>Add a User</span></a>
				</div>
			@endcan
		</div>
	</desktop>

	<div class="row">
		<div class="col-md-3 push-md-9">
			<div class="card">
				<div class="card-header">Filter Users</div>
				
				<div class="card-block">
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
							<div class="checkbox" v-show="pendingCount > 0">
								<label><input type="checkbox" value="{{ Status::toString(Status::PENDING) }}" v-model="statuses"> {{ ucwords(Status::toString(Status::PENDING)) }} <span class="tag tag-warning">@{{ pendingCount }}</span></label>
							</div>
						</div>
					</div>
				</div>

				<div class="card-footer">
					<mobile>
						<a class="btn btn-secondary btn-lg btn-block" @click="resetFilters">Reset Filters</a>
					</mobile>
					<desktop>
						<a class="btn btn-secondary btn-block" @click="resetFilters">Reset Filters</a>
					</desktop>
				</div>
			</div>
		</div>

		<div class="col-md-9 pull-md-3">
			<div class="data-table data-table-bordered data-table-striped">
				<div class="row" v-for="user in users | filterBy search in 'name' 'email' 'characters' | filterByCheckboxes statuses 'status'">
					<div class="col-md-7">
						<p class="lead"><strong>@{{ user.name }}</strong></p>
						<p>@{{ user.email }}</p>
					</div>
					<div class="col-md-2">
						<p><span :class="statusClass(user.status)">@{{ user.status|capitalize }}</span></p>
					</div>
					<div class="col-md-3">
						@can('manage', $user)
							<mobile>
								<div class="row">
									@can('edit', $user)
										<div class="col-sm-6">
											<p><a href="@{{ user.links.edit }}" class="btn btn-secondary btn-lg btn-block">Edit</a></p>
										</div>
									@endcan

									@can('remove', $user)
										<div class="col-sm-6" v-if="user.status != 'pending'">
											<p><a href="#" class="btn btn-danger btn-lg btn-block" @click.prevent="removeUser(user.id)">Remove</a></p>
										</div>
									@endcan
								</div>
							</mobile>
							<desktop>
								<div class="btn-toolbar pull-right">
									<div class="btn-group">
										<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											{!! icon('settings') !!}<span>Actions</span>
										</button>

										<ul class="dropdown-menu dropdown-menu-right">
											@can('edit', $user)
												<li><a href="@{{ user.links.edit }}" class="dropdown-item">Edit</a></li>
											@endcan

											@can('remove', $user)
												<li role="separator" class="dropdown-divider" v-if="user.status != 'pending'"></li>
												<li v-if="user.status != 'pending'"><a href="#" @click.prevent="removeUser(user.id)" class="dropdown-item">Remove</a></li>
											@endcan
										</ul>
									</div>
								</div>
							</desktop>
						@endcan
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@can('remove', $user)
	{!! modal(['id' => "removeUser", 'header' => "Remove User"]) !!}
@endcan