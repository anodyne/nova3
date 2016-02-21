<div class="page-header">
	<h1>Form Fields <small>{!! $form->present()->name !!}</small></h1>
</div>

<div v-cloak>
	<phone-tablet>
		@can('create', $field)
			<p><a href="{{ route('admin.forms.fields.create', $form->key) }}" class="btn btn-success btn-lg btn-block">Add a Field</a></p>
		@endcan

		@can('manage', $form)
			<p><a href="{{ route('admin.forms') }}" class="btn btn-default btn-lg btn-block">Back to Forms</a></p>
		@endcan
	</phone-tablet>
	<desktop>
		<div class="btn-toolbar">
			@can('create', $field)
				<div class="btn-group">
					<a href="{{ route('admin.forms.fields.create', $form->key) }}" class="btn btn-success">Add a Field</a>
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

@if ($unboundFields->count() > 0)
	<div class="{{ ($form->present()->hasHorizontalOrientation) ? 'form-horizontal' : '' }}">
	@foreach ($unboundFields as $field)
		<div class="form-group">
			@if ($form->present()->hasHorizontalOrientation)
				<label class="control-label {{ $field->label_container_class }}">{!! $field->present()->label !!}</label>
				<div class="{{ $field->field_container_class }}">
					{!! $field->present()->render !!}
				</div>
			@endif

			@if ($form->present()->hasVerticalOrientation)
				<div class="row">
					<div class="{{ $field->field_container_class }}">
						<label class="control-label">{!! $field->present()->label !!}</label>
						{!! $field->present()->render !!}
					</div>
				</div>
			@endif
		</div>
	@endforeach
	</div>
@endif

@if ($unboundSections->count() > 0)
	@foreach ($unboundSections as $section)
		<h3>{!! $section->present()->name !!}</h3>

		@if ($section->fields->count() > 0)
			<div class="{{ ($form->present()->hasHorizontalOrientation) ? 'form-horizontal' : '' }}">
			@foreach ($section->fields as $field)
				<div class="form-group">
					@if ($form->present()->hasHorizontalOrientation)
						<label class="control-label {{ $field->label_container_class }}">{!! $field->present()->label !!}</label>
						<div class="{{ $field->field_container_class }}">
							{!! $field->present()->render !!}
						</div>
					@endif

					@if ($form->present()->hasVerticalOrientation)
						<div class="row">
							<div class="{{ $field->field_container_class }}">
								<label class="control-label">{!! $field->present()->label !!}</label>
								{!! $field->present()->render !!}
							</div>
						</div>
					@endif
				</div>
			@endforeach
			</div>
		@endif
	@endforeach
@endif

@if ($tabs->count() > 0)

@endif

@if ($unboundFields->count() == 0 and $unboundSections->count() == 0 and $tabs->count() == 0)
	{!! alert('warning', "There are no tabs, sections, or fields associated with this form. Start designing your form now!") !!}
@endif

@can('remove', $field)
	{!! modal(['id' => "removeField", 'header' => "Remove Form Field"]) !!}
@endcan