<?php $d = data($data, $f->id);?>

@if ($editable)
	<div class="row">
		<div class="{{ $f->html_class }}">
			<div class="control-group">
				<label class="control-label">{{ $f->label }}</label>
				<div class="controls">
					@if (empty($f->restriction) or (Sentry::check() and Sentry::getUser()->hasRole($f->restriction)))
						@if ($f->type == 'text')
							{{ Form::text($f->id, $d, ['id' => $f->html_id, 'placeholder' => $f->placeholder]) }}
						@elseif ($f->type == 'textarea')
							{{ Form::textarea($f->id, $d, ['id' => $f->html_id, 'placeholder' => $f->placeholder, 'rows' => $f->html_rows]) }}
						@elseif ($f->type == 'select')
							{{ Form::select($f->id, $f->getValues(), $d, ['id' => $f->html_id]) }}
						@endif
					@else
						{{ $d }}
					@endif
				</div>
			</div>
		</div>
	</div>

	@if ( ! empty($f->help))
		<div class="row">
			<div class="col-lg-12">
				<p class="help-block">{{ $f->help }}</p>
			</div>
		</div>
	@endif
@else
	@if ( ! empty($d))
		<div class="control-group">
			<label class="control-label">{{ $f->label }}</label>
			<div class="controls">{{ $d }}</div>
		</div>
	@endif
@endif