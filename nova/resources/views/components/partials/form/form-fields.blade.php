@if ($fields->count() > 0)
	@foreach ($fields as $field)
		@php
		$restriction = $field->restrictionForType($action);
		
		$showField = ( ! empty($restriction) and $_user->hasRole($restriction) or empty($restriction));

		$fieldData = ($data) ? $data->whereLoose('field_id', $field->id) : null;
		$fieldData = ($fieldData->count() > 0 and $action != 'create') ? $fieldData->first()->value : null;

		$fieldName = sprintf(config('nova.forms.fieldNameFormat'), $field->id);
		@endphp
		
		@if ($showField)
			@if ($form->orientation == 'horizontal')
				@if ($editable or ! $editable and ! empty($fieldData))
					<div class="form-group{{ ($errors->has($fieldName)) ? ' has-error' : '' }}">
						@if (strlen($field->label) > 0)
							<label class="control-label {{ $field->label_container_class }}">{!! $field->present()->label !!}</label>
						@endif

						@if ($editable)
							<div class="{{ $field->field_container_class }}">
								{!! $field->present()->render($id, $action, $fieldNameWrapper) !!}

								@if (strlen($field->help) > 0)
									<p class="help-block">{!! $field->present()->help !!}</p>
								@endif

								{!! $errors->first($fieldName, '<p class="help-block">:message</p>') !!}
							</div>
						@else
							<p class="form-control-static">{!! $fieldData !!}</p>
						@endif
					</div>
				@endif
			@else
				@if ($editable or ! $editable and ! empty($fieldData))
					<div class="form-group{{ ($errors->has($fieldName)) ? ' has-error' : '' }}">
						<div class="row">
							<div class="{{ $field->field_container_class }}">
								@if (strlen($field->label) > 0)
									<label class="control-label">{!! $field->present()->label !!}</label>
								@endif
								
								@if ($editable)
									<div>{!! $field->present()->render($id, $action, $fieldNameWrapper) !!}</div>

									@if (strlen($field->help) > 0)
										<p class="help-block">{!! $field->present()->help !!}</p>
									@endif

									{!! $errors->first($fieldName, '<p class="help-block">:message</p>') !!}
								@else
									<p class="form-control-static">{!! $fieldData !!}</p>
								@endif
							</div>
						</div>
					</div>
				@endif
			@endif
		@endif
	@endforeach
@endif