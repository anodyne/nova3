@if (is_array($fields) and array_key_exists($s->id, $fields))
	<fieldset>
		@if ( ! empty($s->name))
			<legend>{{ $s->name }}</legend>
		@endif

		@foreach ($fields[$s->id] as $f)
			{{ partial('forms/field', ['f' => $f, 'data' => $data, 'editable' => $editable]) }}
		@endforeach
	</fieldset>
@endif