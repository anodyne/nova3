<div v-cloak>
	<mobile>
		@can('create', $form)
			<p><a href="{{ route('admin.forms.create') }}" class="btn btn-success btn-lg btn-block">Add a Form</a></p>
		@endcan
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			@can('create', $form)
				<div class="btn-group">
					<a href="{{ route('admin.forms.create') }}" class="btn btn-success">Add a Form</a>
				</div>
			@endcan
		</div>
	</desktop>
</div>

<div class="data-table data-table-striped data-table-bordered">
@foreach ($forms as $form)
	<div class="row">
		<div class="col-md-6">
			<p class="lead"><strong>{{ $form->present()->name }}</strong></p>
			<p><strong>Key:</strong> {{ $form->present()->key }}</p>
			<p>{!! $form->present()->statusAsLabel !!}</p>
		</div>
		<div class="col-md-6" v-cloak>
			<mobile>
				<div class="row">
					@if ($form->use_form_center)
						<div class="col-xs-12">
							<p><a href="#" class="btn btn-default btn-lg btn-block">Dashboard</a></p>
						</div>
					@endif

					<div class="col-xs-12">
						<p><a href="{{ route('admin.forms.preview', [$form->key]) }}" class="btn btn-default btn-lg btn-block">Preview</a></p>
					</div>

					@can('edit', $form)
						<div class="col-xs-12 col-sm-6">
							<p><a href="{{ route('admin.forms.edit', [$form->key]) }}" class="btn btn-default btn-lg btn-block">Edit Form</a></p>
						</div>

						@can('manage', $formTab)
							<div class="col-xs-12 col-sm-6">
								<p><a href="{{ route('admin.forms.tabs', [$form->key]) }}" class="btn btn-default btn-lg btn-block">Edit Form Tabs</a></p>
							</div>
						@endcan

						@can('manage', $formSection)
							<div class="col-xs-12 col-sm-6">
								<p><a href="{{ route('admin.forms.sections', [$form->key]) }}" class="btn btn-default btn-lg btn-block">Edit Form Sections</a></p>
							</div>
						@endcan

						@can('manage', $formField)
							<div class="col-xs-12 col-sm-6">
								<p><a href="{{ route('admin.forms.fields', [$form->key]) }}" class="btn btn-default btn-lg btn-block">Edit Form Fields</a></p>
							</div>
						@endcan
					@endcan

					@can('remove', $form)
						<div class="col-xs-12">
							<p><a href="#" class="btn btn-danger btn-lg btn-block" @click.prevent="removeForm({{ $form->key }})">Remove</a></p>
						</div>
					@endcan
				</div>
			</mobile>
			<desktop>
				<div class="btn-toolbar pull-right">
					@if ($form->use_form_center)
						<div class="btn-group">
							<a href="#" class="btn btn-default">Dashboard</a>
						</div>
					@endif

					<div class="btn-group">
						<a href="{{ route('admin.forms.preview', [$form->key]) }}" class="btn btn-default">Preview</a>
					</div>

					@can('edit', $form)
						<div class="btn-group">
							<a href="{{ route('admin.forms.edit', [$form->key]) }}" class="btn btn-default">Edit</a>
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu dropdown-menu-right" role="menu">
								@can('manage', $formTab)
									<li><a href="{{ route('admin.forms.tabs', [$form->key]) }}">Tabs</a></li>
								@endcan

								@can('manage', $formSection)
									<li><a href="{{ route('admin.forms.sections', [$form->key]) }}">Sections</a></li>
								@endcan

								@can('manage', $formField)
									<li><a href="{{ route('admin.forms.fields', [$form->key]) }}">Fields</a></li>
								@endcan
							</ul>
						</div>
					@endcan

					@can('remove', $form)
						<div class="btn-group">
							<a href="#" class="btn btn-danger" data-form-key="{{ $form->key }}" @click.prevent="removeForm">Remove</a>
						</div>
					@endcan
				</div>
			</desktop>
		</div>
	</div>
@endforeach
</div>

@can('remove', $form)
	{!! modal(['id' => "removeForm", 'header' => "Remove Form"]) !!}
@endcan