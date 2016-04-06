<div class="page-header">
	<h1>Form Sections <small>{!! $form->present()->name !!}</small></h1>
</div>

<div v-cloak>
	<mobile>
		@can('create', $section)
			<p><a href="{{ route('admin.forms.sections.create', $form->key) }}" class="btn btn-success btn-lg btn-block">Add a Section</a></p>
		@endcan

		@can('manage', $form)
			<p><a href="{{ route('admin.forms') }}" class="btn btn-default btn-lg btn-block">Back to Forms</a></p>
		@endcan
	</mobile>
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
					<span class="uk-icon uk-icon-bars sortable-handle"></span>
					<strong>{{ $section->present()->name }}</strong>
				</p>
				<p>{!! $section->present()->statusAsLabel !!}</p>
			</div>
			<div class="col-md-6 controls" v-cloak>
				<mobile>
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
				</mobile>
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
		@php($panelClass = ($tab->sectionsAll->count() > 0) ? 'panel-default' : 'panel-warning')
		<div class="panel {{ $panelClass }}">
			<div class="panel-heading">
				<h3 class="panel-title">{!! $tab->present()->name !!}</h3>
			</div>
			<div class="panel-body">
				@if ($tab->sectionsAll->count() > 0)
					<div class="data-table data-table-striped data-table-bordered">
					@foreach ($tab->sectionsAll as $section)
						<div class="row" data-id="{{ $section->id }}">
							<div class="col-md-6">
								<p class="lead">
									<span class="uk-icon uk-icon-bars sortable-handle"></span>
									<strong>{{ $section->present()->name }}</strong>
								</p>
								<p>{!! $section->present()->statusAsLabel !!}</p>
							</div>
							<div class="col-md-6 controls" v-cloak>
								<mobile>
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
								</mobile>
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
				@else
					<p class="text-warning">The {{ $tab->present()->name }} form tab doesn't contain any sections</p>

					<mobile>
						<a href="{{ route('admin.forms.sections.create', $form->key) }}" class="btn btn-lg btn-block btn-success">Add a Section</a>
					</mobile>
					<desktop>
						<a href="{{ route('admin.forms.sections.create', $form->key) }}" class="btn btn-success">Add a Section</a>
					</desktop>
				@endif
			</div>
		</div>
	@endforeach
@endif

@can('remove', $section)
	{!! modal(['id' => "removeSection", 'header' => "Remove Form Section"]) !!}
@endcan