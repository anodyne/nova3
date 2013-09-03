<?php $d = DynamicForm::displayData($data, $field->id);?>

@if ($editable)
	<div class="row">
		<div class="{{ $field->html_container_class }}">

			@if (empty($field->help))
				<div class="form-group">
			@endif

				<label class="control-label">{{ $field->label }}</label>
				@if (empty($field->restriction) or (Sentry::check() and Sentry::getUser()->hasRole($field->restriction)))
					@if ($field->type == 'text')
						{{ Form::text($field->id, $d, ['id' => $field->html_id, 'placeholder' => $field->placeholder, 'class' => "{$field->html_class} form-control"]) }}
					@elseif ($field->type == 'textarea')
						{{ Form::textarea($field->id, $d, ['id' => $field->html_id, 'placeholder' => $field->placeholder, 'rows' => $field->html_rows, 'class' => "{$field->html_class} form-control"]) }}
					@elseif ($field->type == 'select')
						{{ Form::select($field->id, $field->getValues(), $d, ['id' => $field->html_id, 'class' => "{$field->html_class} form-control"]) }}
					@endif
				@else
					{{ $d }}
				@endif
			
			@if (empty($field->help))
				</div>
			@endif
		</div>
	</div>

	@if ( ! empty($field->help))
		<div class="row">
			<div class="col-lg-12">
				<p class="help-block">{{ $field->help }}</p>
			</div>
		</div>
	@endif
@else
	@if ( ! empty($d))
		<div class="row">
			<div class="col-lg-12">
				<div class="form-group">
					<label class="control-label">{{ $field->label }}</label>
					{{ Markdown::parse($d) }}
				</div>
			</div>
		</div>
	@endif
@endif