@if ($sections->count() > 0)
	@foreach ($sections as $section)
		<h3>{!! $section->present()->name !!}</h3>

		@if ($section->fields->count() > 0)
			{!! partial('form-fields', ['fields' => $section->fields, 'editable' => $editable, 'form' => $form]) !!}
		@endif
	@endforeach
@endif