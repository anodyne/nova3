@if ($sections->count() > 0)
	@foreach ($sections as $section)
		<fieldset>
			<legend>{!! $section->present()->name !!}</legend>

			@if ($section->fields->count() > 0)
				<div class="fieldset-content">
					{!! partial('form-fields', ['fields' => $section->fields, 'editable' => $editable, 'form' => $form]) !!}
				</div>
			@endif
		</fieldset>
	@endforeach
@endif