<fieldset>
	@if ( ! empty($section->name))
		<legend>{{ $section->name }}</legend>
	@endif

	@foreach ($fields as $field)
		{{ partial('forms/field', ['field' => $field, 'data' => $data, 'editable' => $editable]) }}
	@endforeach
</fieldset>