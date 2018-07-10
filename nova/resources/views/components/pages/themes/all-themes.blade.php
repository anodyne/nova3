<page-header>
	<template slot="pretitle">Presentation</template>
	<template slot="title">Themes</template>
</page-header>

@if ($themes->count() > 0)
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
						<nova-dropdown direction="right">
							<icon name="more" class="btn-icon" slot="trigger-simple"></icon>

							<a class="dropdown-item" :href="editLink(role.id)">
								{{ _m('edit') }}
							</a>
							<a class="dropdown-item is-danger" href="#" @click.prevent="deleteRole(role.id)">
								{{ _m('delete') }}
							</a>
						</nova-dropdown>
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
