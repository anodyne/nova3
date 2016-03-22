@if ($sections->count() > 0)
	@foreach ($sections as $section)
		<fieldset>
			<legend>{!! $section->present()->name !!}</legend>

			{!! $section->present()->message !!}

			@if ($section->fields->count() > 0)
				<div class="fieldset-content">
					{!! partial('form-fields', ['fields' => $section->fields, 'editable' => $editable, 'form' => $form, 'action' => $action, 'data' => $data, 'id' => $id]) !!}
				</div>
			@endif
		</fieldset>
	@endforeach
@endif