<page-header>
	<template slot="pretitle">Authorization</template>
	<template slot="title">{{ _m('authorize-roles') }}</template>
	<template slot="controls">
		<div class="flex items-center">
			@can('create', $roleClass)
				<a href="{{ route('roles.create') }}" class="button is-primary">
					<icon name="add" class="btn-icon"></icon>
					<span>Add a Role</span>
				</a>
			@endcan

			@can('manage', $permissionClass)
				<div class="dropdown is-right ml-3">
					<div class="dropdown-trigger">
						<button type="button"
								class="button is-flush"
								data-toggle="dropdown"
								aria-haspopup="true"
								aria-expanded="false"
						>
							<icon name="more"></icon>
						</button>
					</div>

					<div class="dropdown-menu">
						<div class="dropdown-content">
							@can('manage', $permissionClass)
								<a href="{{ route('permissions.index') }}" class="dropdown-item">
									{{-- <icon name="lock" :wrapper="{ class:'dropdown-icon' }"></icon> --}}
									{{ _m('authorize-permissions') }}
								</a>
							@endcan
						</div>
					</div>
				</div>
			@endcan
		</div>
	</template>
</page-header>

@if ($roles->count() > 0)
	<app-card>
		<template slot="card-block">
			<div class="data-table is-rounded in-card has-controls">
				<div class="row is-header">
					<div class="col">
						{{ _m('name') }}
					</div>
				</div>

				<div class="row" v-for="role in roles">
					<div class="col">
						@{{ role.name }}
					</div>
					<div class="col-auto row-controls">
						<div class="dropdown is-right ml-2">
							<div class="dropdown-trigger">
								<button type="button"
										class="button is-flush"
										data-toggle="dropdown"
										aria-haspopup="true"
										aria-expanded="false"
								>
									<icon name="more" class="btn-icon" />
								</button>
							</div>

							<div class="dropdown-menu">
								<div class="dropdown-content">
									@can('update', $roleClass)
										<a class="dropdown-item" :href="editLink(role.id)">
											{{ _m('edit') }}
										</a>
									@endcan

									@can('delete', $roleClass)
										<a class="dropdown-item is-danger" href="#" @click.prevent="deleteRole(role.id)">
											{{ _m('delete') }}
										</a>
									@endcan
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</template>
	</app-card>
@else
	<div class="alert alert-warning">
		{{ _m('authorize-roles-error-not-found') }} <a href="{{ route('roles.create') }}" class="alert-link">{{ _m('authorize-roles-error-add') }}</a>
	</div>
@endif
