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

@can('remove', $field)
	{!! modal(['id' => "removeField", 'header' => "Remove Form Field"]) !!}
@endcan