<h1>{{ _m('authorize-roles') }}</h1>

@if ($roles->count() > 0)
	<div class="data-table is-bordered is-striped">
		<div class="row is-header">
			<div class="col">
				{{ _m('name') }}
			</div>
			<div class="col-auto">
				<div class="btn-toolbar">
					@can('create', $roleClass)
						<a href="{{ route('roles.create') }}" class="button is-success">
							<icon name="add" />
						</a>
					@endcan

					@can('manage', $permissionClass)
						<div class="dropdown is-right ml-2">
							<div class="dropdown-trigger">
								<button type="button"
	  									class="button is-secondary btn-action"
	  									data-toggle="dropdown"
	  									aria-haspopup="true"
	  									aria-expanded="false">
									<icon name="more" />
								</button>
							</div>

							<div class="dropdown-menu">
								<div class="dropdown-content">
									@can('manage', $permissionClass)
										<a href="{{ route('permissions.index') }}" class="dropdown-item">
											<icon name="lock" :wrapper="{ class:'dropdown-icon' }"></icon>
											{{ _m('authorize-permissions') }}
										</a>
									@endcan
								</div>
							</div>
						</div>
					@endcan
				</div>
			</div>
		</div>

		<div class="row" v-for="role in roles">
			<div class="col">
				@{{ role.name }}
			</div>
			<div class="col-auto">
				<div class="dropdown is-right ml-2">
					<div class="dropdown-trigger">
						<button type="button"
									class="button is-secondary btn-action"
									data-toggle="dropdown"
									aria-haspopup="true"
									aria-expanded="false">
							<icon name="more" />
						</button>
					</div>

					<div class="dropdown-menu">
						<div class="dropdown-content">
							@can('update', $roleClass)
								<a class="dropdown-item" :href="editLink(role.id)">
									<icon name="edit" :wrapper="{ class:'dropdown-icon' }"></icon>
									{{ _m('edit') }}
								</a>
							@endcan

							@can('delete', $roleClass)
								<a class="dropdown-item text-danger" href="#" @click.prevent="deleteRole(role.id)">
									<icon name="delete" :wrapper="{ class:'dropdown-icon' }"></icon>
									{{ _m('delete') }}
								</a>
							@endcan
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@else
	<div class="alert alert-warning">
		{{ _m('authorize-roles-error-not-found') }} <a href="{{ route('roles.create') }}" class="alert-link">{{ _m('authorize-roles-error-add') }}</a>
	</div>
@endif