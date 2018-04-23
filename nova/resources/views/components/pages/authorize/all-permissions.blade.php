<h1>{{ _m('authorize-permissions') }}</h1>

@if ($permissions->count() > 0)
	<div class="data-table is-bordered is-striped">
		<div class="row is-header">
			<div class="col">
				<mobile>
					<a href="#"
					   class="button is-secondary btn-action"
					   v-show="!mobileSearch"
					   @click.prevent="mobileSearch = true">
					   	<icon name="search" />
					</a>

					<text-input placeholder="{{ _m('authorize-permissions-find') }}" v-model="search">
						<template slot="field-addon-after">
							<a href="#" class="leading-0" @click.prevent="resetSearch">
								<icon name="close" />
							</a>
						</template>
					</text-input>
				</mobile>
				<desktop>
					<text-input placeholder="{{ _m('authorize-permissions-find') }}" v-model="search">
						<template slot="field-addon-after">
							<a href="#" class="leading-0" @click.prevent="resetSearch">
								<icon name="close" />
							</a>
						</template>
					</text-input>
				</desktop>
			</div>
			<div class="col"></div>
			<div class="col-auto" v-show="!mobileSearch">
				<div class="btn-toolbar">
					@can('create', $permissionClass)
						<a href="{{ route('permissions.create') }}" class="button is-success">
							<icon name="add" />
						</a>
					@endcan

					@can('manage', $roleClass)
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
									@can('manage', $roleClass)
										<a href="{{ route('roles.index') }}" class="dropdown-item">
											<icon name="lock" :wrapper="{ class:'dropdown-icon' }"></icon>
											{{ _m('authorize-roles') }}
										</a>
									@endcan
								</div>
							</div>
						</div>
					@endcan
				</div>
			</div>
		</div>

		<div class="row align-items-center" v-for="permission in filteredPermissions">
			<div class="col">
				@{{ permission.name }}
			</div>
			<div class="col col-auto">
				<div class="dropdown is-right">
					<div class="dropdown-trigger">
						<button class="button is-secondary btn-action"
								type="button"
								id="dropdownMenuButton"
								data-toggle="dropdown"
								aria-haspopup="true"
								aria-expanded="false">
							<icon name="more" />
						</button>
					</div>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<div class="dropdown-content">
							@can('update', $permissionClass)
								<a :href="editLink(permission.id)" class="dropdown-item">
									<icon name="edit" :wrapper="{ class:'dropdown-icon' }"></icon>
									{{ _m('edit') }}
								</a>
							@endcan

							@can('delete', $permissionClass)
								<a href="#" class="dropdown-item text-danger" @click.prevent="deletePermission(permission.id)">
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
		{{ _m('authorize-permissions-error-not-found') }} <a href="{{ route('permissions.create') }}" class="alert-link">{{ _m('authorize-permissions-error-add') }}</a>
	</div>
@endif