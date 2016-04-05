@if ($fields->count() > 0)
	<div class="sortable {{ ($form->present()->hasHorizontalOrientation) ? 'form-horizontal' : '' }}">
	@foreach ($fields as $field)
		<div class="row" data-id="{{ $field->id }}">
			<div class="col-xs-1">
				<p class="text-center"><span class="uk-icon uk-icon-bars sortable-handle"></span></p>
			</div>
			<div class="col-xs-11 col-md-9">
				@if ($form->orientation == 'horizontal')
					<div class="form-group">
						@if (strlen($field->label) > 0)
							<label class="control-label {{ $field->label_container_class }}">{!! $field->present()->label !!}</label>
						@endif

						<div class="{{ $field->field_container_class }}">
							{!! $field->present()->render() !!}

							@if (strlen($field->help) > 0)
								<p class="help-block">{!! $field->present()->help !!}</p>
							@endif
						</div>
					</div>
				@else
					<div class="form-group">
						<div class="row">
							<div class="{{ $field->field_container_class }}">
								@if (strlen($field->label) > 0)
									<label class="control-label">{!! $field->present()->label !!}</label>
								@endif

								<div>{!! $field->present()->render() !!}</div>
							</div>
						</div>
					</div>
				@endif
			</div>
			<div class="col-xs-12 col-md-2 controls" v-cloak>
				<mobile>
					<div class="row">
						@can('edit', $field)
							<div class="col-xs-12">
								<p><a href="{{ route('admin.forms.fields.edit', [$form->key, $field->id]) }}" class="btn btn-default btn-lg btn-block">Edit</a></p>
							</div>
						@endcan

						@can('remove', $field)
							<div class="col-xs-12">
								<p><a href="#" class="btn btn-danger btn-lg btn-block" data-form-key="{{ $form->key }}" data-id="{{ $field->id }}" @click.prevent="removeField">Remove</a></p>
							</div>
						@endcan
					</div>
				</mobile>
				<desktop>
					<div class="btn-toolbar pull-right">
						@can('edit', $field)
							<div class="btn-group">
								<a href="{{ route('admin.forms.fields.edit', [$form->key, $field->id]) }}" class="btn btn-default">Edit</a>
							</div>
						@endcan

						@can('remove', $field)
							<div class="btn-group">
								<a href="#" class="btn btn-danger" data-form-key="{{ $form->key }}" data-id="{{ $field->id }}" @click.prevent="removeField">Remove</a>
							</div>
						@endcan
					</div>
				</desktop>
			</div>
		</div>
	@endforeach
	</div>
@endif