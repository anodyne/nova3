<page-header>
	<template slot="pretitle">Authorization</template>
	<template slot="title">{{ _m('authorize-permissions') }}</template>
	<template slot="controls">
		<div class="flex items-center">
			@can('create', $permissionClass)
				<a href="{{ route('permissions.create') }}" class="button is-primary">
					<icon name="add" class="btn-icon"></icon>
					<span>Add a Permission</span>
				</a>
			@endcan

			@can('manage', $roleClass)
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
	</template>
</page-header>

@if ($permissions->count() > 0)
	<app-card>
		<template slot="card-header">
			<div class="flex-1 flex items-center">
				<icon name="search" class="text-grey mr-2"></icon>
				<input type="text" name="" id="" placeholder="Search..." class="appearance-none w-1/2" v-model="search">
			</div>
		</template>

		<template slot="card-block">
			<div class="data-table is-rounded-bottom in-card has-controls">
				<div class="row is-header">
					<div class="col">
						{{ _m('name') }}
					</div>
				</div>

				<div class="row" v-for="permission in filteredPermissions">
					<div class="col">
						@{{ permission.name }}
					</div>
					<div class="col-auto row-controls">
						<div class="dropdown is-right">
							<div class="dropdown-trigger">
								<button class="button is-flush"
										type="button"
										id="dropdownMenuButton"
										data-toggle="dropdown"
										aria-haspopup="true"
										aria-expanded="false"
								>
									<icon name="more" class="btn-icon"></icon>
								</button>
							</div>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
								<div class="dropdown-content">
									@can('update', $permissionClass)
										<a :href="editLink(permission.id)" class="dropdown-item">
											{{ _m('edit') }}
										</a>
										<a :href="editLink(permission.id)" class="dropdown-item">
											Add to Role...
										</a>
										<div class="dropdown-divider"></div>
									@endcan

									@can('delete', $permissionClass)
										<a href="#" class="dropdown-item text-danger" @click.prevent="deletePermission(permission.id)">
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
		{{ _m('authorize-permissions-error-not-found') }} <a href="{{ route('permissions.create') }}" class="alert-link">{{ _m('authorize-permissions-error-add') }}</a>
	</div>
@endif
