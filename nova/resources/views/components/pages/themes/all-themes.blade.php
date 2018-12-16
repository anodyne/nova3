<page-header>
	<template slot="pretitle">Presentation</template>
	<template slot="title">{{ $_page->getContentByType('page-header')->content }}</template>
</page-header>

<div class="border-2 border-dashed p-12 text-center rounded bg-grey-lightest">
	<div class="block mx-auto mb-6">
		{{ svg_icon('blank-canvas', 'h-64 w-auto') }}
	</div>

	<h2 class="text-xl font-semibold mb-6">Let your creativity run wild!</h2>

	<div class="row">
		<div class="col-5 col-offset-1">
			<a href="#" class="button is-block is-large is-primary">Create a new theme</a>
		</div>
		<div class="col-5">
			<a href="#" class="button is-block is-large is-subtle">Find a theme</a>
		</div>
	</div>
</div>

@if ($themes->count() > 0)
	<app-card>
		<template slot="card-block">
			<div class="data-table is-rounded in-card has-controls">
				<div class="row is-header">
					<div class="col">
						Name
					</div>
				</div>

				<div class="row" v-for="theme in themes">
					<div class="col">
						@{{ theme.name }}
					</div>
					<div class="col-auto row-controls">
						<nova-dropdown direction="right">
							<app-icon name="more" class="btn-icon" slot="trigger-simple"></app-icon>

							<a class="dropdown-item" :href="editLink(theme.id)">
								Edit
							</a>
							<a class="dropdown-item is-danger" href="#" @click.prevent="deleteTheme(theme.id)">
								Delete
							</a>
						</nova-dropdown>
					</div>
				</div>
			</div>
		</template>
	</app-card>
@else
	<div class="alert alert-warning">

	</div>
@endif