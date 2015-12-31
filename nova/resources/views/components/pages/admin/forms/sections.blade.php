<div class="page-header">
	<h1>Form Sections <small>{!! $form->present()->name !!}</small></h1>
</div>

<div v-cloak>
	<phone-tablet>
		@can('create', $section)
			<p><a href="{{ route('admin.forms.sections.create', $form->key) }}" class="btn btn-success btn-lg btn-block">Add a Section</a></p>
		@endcan

		@can('manage', $form)
			<p><a href="{{ route('admin.forms') }}" class="btn btn-default btn-lg btn-block">Back to Forms</a></p>
		@endcan
	</phone-tablet>
	<desktop>
		<div class="btn-toolbar">
			@can('create', $section)
				<div class="btn-group">
					<a href="{{ route('admin.forms.sections.create', $form->key) }}" class="btn btn-success">Add a Section</a>
				</div>
			@endcan

			@can('manage', $form)
				<div class="btn-group">
					<a href="{{ route('admin.forms') }}" class="btn btn-default">Back to Forms</a>
				</div>
			@endcan
		</div>
	</desktop>
</div>

@if ($unboundSections->count() > 0)
	<div class="data-table data-table-striped data-table-bordered">
	@foreach ($unboundSections as $section)
		<div class="row" data-id="{{ $section->id }}">
			<div class="col-md-6">
				<p class="lead">
					<span class="uk-icon uk-icon-bars text-muted sortable-handle"></span>
					<strong>{{ $section->present()->name }}</strong>
				</p>
			</div>
			<div class="col-md-6 controls" v-cloak>
				<phone-tablet>
					<div class="row">
						@can('edit', $section)
							<div class="col-xs-12">
								<p><a href="{{ route('admin.forms.sections.edit', [$form->key, $section->id]) }}" class="btn btn-default btn-lg btn-block">Edit</a></p>
							</div>
						@endcan

						@can('remove', $section)
							<div class="col-xs-12">
								<p><a href="#" class="btn btn-danger btn-lg btn-block" data-form-key="{{ $form->key }}" data-id="{{ $section->id }}" @click.prevent="removeSection">Remove</a></p>
							</div>
						@endcan
					</div>
				</phone-tablet>
				<desktop>
					<div class="btn-toolbar pull-right">
						@can('edit', $section)
							<div class="btn-group">
								<a href="{{ route('admin.forms.sections.edit', [$form->key, $section->id]) }}" class="btn btn-default">Edit</a>
							</div>
						@endcan

						@can('remove', $section)
							<div class="btn-group">
								<a href="#" class="btn btn-danger" data-form-key="{{ $form->key }}" data-id="{{ $section->id }}" @click.prevent="removeSection">Remove</a>
							</div>
						@endcan
					</div>
				</desktop>
			</div>
		</div>
	@endforeach
	</div>	
@endif

@if ($tabs->count() > 0)
	@foreach ($tabs as $tab)
		@if ($tab->sections->count() > 0)
			<h3>{!! $tab->present()->name !!}</h3>

			<div class="data-table data-table-striped data-table-bordered">
			@foreach ($tab->sections as $section)
				<div class="row" data-id="{{ $section->id }}">
					<div class="col-md-6">
						<p class="lead">
							<span class="uk-icon uk-icon-bars text-muted sortable-handle"></span>
							<strong>{{ $section->present()->name }}</strong>
						</p>
					</div>
					<div class="col-md-6 controls" v-cloak>
						<phone-tablet>
							<div class="row">
								@can('edit', $section)
									<div class="col-xs-12">
										<p><a href="{{ route('admin.forms.sections.edit', [$form->key, $section->id]) }}" class="btn btn-default btn-lg btn-block">Edit</a></p>
									</div>
								@endcan

								@can('remove', $section)
									<div class="col-xs-12">
										<p><a href="#" class="btn btn-danger btn-lg btn-block" data-form-key="{{ $form->key }}" data-id="{{ $section->id }}" @click.prevent="removeSection">Remove</a></p>
									</div>
								@endcan
							</div>
						</phone-tablet>
						<desktop>
							<div class="btn-toolbar pull-right">
								@can('edit', $section)
									<div class="btn-group">
										<a href="{{ route('admin.forms.sections.edit', [$form->key, $section->id]) }}" class="btn btn-default">Edit</a>
									</div>
								@endcan

								@can('remove', $section)
									<div class="btn-group">
										<a href="#" class="btn btn-danger" data-form-key="{{ $form->key }}" data-id="{{ $section->id }}" @click.prevent="removeSection">Remove</a>
									</div>
								@endcan
							</div>
						</desktop>
					</div>
				</div>
			@endforeach
			</div>
		@endif
	@endforeach
@endif

@can('remove', $section)
	{!! modal(['id' => "removeSection", 'header' => "Remove Form Section"]) !!}
@endcan