<page-header>
	<template slot="pretitle">Presentation</template>
	<template slot="title">Themes</template>
	<template slot="controls">
		<div class="flex items-center">
				<a href="{{ route('permissions.create') }}" class="button is-primary">
					<icon name="add" class="btn-icon"></icon>
					<span>Add a Permission</span>
				</a>

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
								<a href="{{ route('roles.index') }}" class="dropdown-item">
									<icon name="lock" :wrapper="{ class:'dropdown-icon' }"></icon>
									{{ _m('authorize-roles') }}
								</a>
						</div>
					</div>
				</div>
		</div>
	</template>
</page-header>

<icon-r name="more"
		wrapper-class="foo"
		:wrapper-attrs="{ id: 'bar' }"
		icon-class="bar"
		:icon-attrs="{ id: 'foo' }"
></icon-r>

@if ($themes->count() > 0)
	<app-card>
		<template slot="card-block">
			<div class="data-table is-rounded in-card has-controls">
				<div class="row is-header">
					<div class="col">
						{{ _m('name') }}
					</div>
				</div>

				<div class="row" v-for="theme in themes">
					<div class="col">
						@{{ theme.name }}
					</div>
					<div class="col-auto row-controls">
						<nova-dropdown direction="right">
							<icon name="more" class="btn-icon" slot="trigger-simple"></icon>

							<a class="dropdown-item" :href="editLink(theme.id)">
								{{ _m('edit') }}
							</a>
							<a class="dropdown-item is-danger" href="#" @click.prevent="deleteTheme(theme.id)">
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
