<div v-cloak>
	<mobile>
		@can('create', $user)
			<p><a href="{{ route('admin.users.create') }}" class="btn btn-success btn-lg btn-block">{!! icon('add') !!}<span>Add a User</span></a></p>
		@endcan
	</mobile>

	<div class="data-table bordered striped">
		<div class="row header">
			<div class="col">
				<div class="input-group">
					{!! Form::text('searchName', null, ['class' => 'form-control', 'v-model' => 'search', 'placeholder' => _m('users-filter')]) !!}
					<span class="input-group-btn">
						<button class="btn btn-secondary" type="button" @click.prevent="resetFilters">{!! icon('close') !!}</button>
					</span>
				</div>
			</div>
			<div class="col-md-6">
				<desktop>
					<div class="btn-toolbar pull-right">
						@can('create', $user)
							<div class="btn-group">
								<a href="{{ route('admin.users.create') }}" class="btn btn-success">{!! icon('add') !!}<span>{{ _m('users-add') }}</span></a>
							</div>
						@endcan
					</div>
				</desktop>
			</div>
		</div>
		<div class="row" v-for="user in filteredUsers">
			<div class="col-md-7">
				<p class="lead"><strong>@{{ user.name }}</strong></p>
				<p>@{{ user.email }}</p>
			</div>
			<div class="col-md-2">
				<p><span :class="statusClass(user.status)">@{{ statusDisplay(user.status) }}</span></p>
			</div>
			<div class="col-md-3">
				@can('manage', $user)
					<mobile>
						<div class="row">
							@can('edit', $user)
								<div class="col-sm-6">
									<p><a :href="user.links.edit" class="btn btn-secondary btn-lg btn-block">Edit</a></p>
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
										<li><a :href="user.links.edit" class="dropdown-item">Edit</a></li>
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

@can('remove', $user)
	{!! modal(['id' => "removeUser", 'header' => "Remove User"]) !!}
@endcan