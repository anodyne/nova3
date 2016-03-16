@if ($fields->count() > 0)
	@foreach ($fields as $field)
		@if ($form->orientation == 'horizontal')
			<div class="form-group">
				<label class="control-label {{ $field->label_container_class }}">{!! $field->present()->label !!}</label>

				@if ($editable)
					<div class="{{ $field->field_container_class }}">
						{!! $field->present()->render !!}

						@if (strlen($field->help) > 0)
							<p class="help-block">{!! $field->present()->help !!}</p>
						@endif
					</div>
				@else
					<p class="form-control-static">Value</p>
				@endif
			</div>
		@else
			<div class="form-group">
				<div class="row">
					<div class="{{ $field->field_container_class }}">
						<label class="control-label">{!! $field->present()->label !!}</label>
						
						@if ($editable)
							<div>{!! $field->present()->render !!}</div>

							@if (strlen($field->help) > 0)
								<p class="help-block">{!! $field->present()->help !!}</p>
							@endif
						@else
							<p class="form-control-static">Value</p>
						@endif
					</div>
				</div>
			</div>
		@endif
	@endforeach
@endif