<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/form') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>

	@if (Sentry::getUser()->hasAccess('form.create'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/form/fields/'.$formKey.'/0') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
		</div>
	@endif

	<div class="btn-group">
		<a href="{{ URL::to('admin/form/tabs/'.$formKey) }}" class="btn btn-default icn-size-16">{{ lang('Tabs') }}</a>
		<a href="{{ URL::to('admin/form/sections/'.$formKey) }}" class="btn btn-default icn-size-16">{{ lang('Sections') }}</a>
	</div>
</div>

@if (count($tabs) > 0)
	<ul class="nav nav-tabs">
	@foreach ($tabs as $t)
		<li><a href="#{{ $t['tab']->link_id }}" data-toggle="tab">{{ $t['tab']->name }}</a></li>
	@endforeach
	</ul>

	<div class="tab-content">
		@foreach ($tabs as $t)
			<div class="tab-pane" id="{{ $t['tab']->link_id }}">
				@if (array_key_exists('fields', $t))
					<div class="nv-data-table nv-data-table-striped nv-data-table-bordered sortableFields">
					@foreach ($t['fields'] as $field)
						<div class="row" id="field_{{ $field->id }}">
							<div class="col-12 col-sm-8 col-lg-9">
								<div class="row">
									<div class="{{ $field->html_container_class }}">
										<div class="control-group">
											<label class="control-label">
												{{ $field->label }}
												@if ($field->status === Status::INACTIVE)
													<span class="label label-danger">({{ lang('Inactive') }})</span>
												@endif
											</label>
											<div class="controls">
												@if ($field->type == 'text')
													{{ Form::text($field->id, $field->value, ['placeholder' => $field->placeholder]) }}
												@elseif ($field->type == 'textarea')
													{{ Form::textarea($field->id, $field->value, ['placeholder' => $field->placeholder, 'rows' => $field->html_rows]) }}
												@elseif ($field->type == 'select')
													{{ Form::select($field->id, $field->getValues(), $field->value) }}
												@endif
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-4 col-lg-3">
								<div class="hidden-sm">
									<div class="btn-toolbar pull-right">
										@if (Sentry::getUser()->hasAccess('form.update'))
											<div class="btn-group">
												<a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$field->id) }}" class="btn btn-small btn-default icn-size-16">{{ $_icons['edit'] }}</a>
											</div>
										@endif

										@if (Sentry::getUser()->hasAccess('form.delete'))
											<div class="btn-group">
												<a href="#" class="btn btn-small btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $field->id }}">{{ $_icons['remove'] }}</a>
											</div>
										@endif
									</div>
								</div>
								<div class="visible-sm">
									<div class="row">
										@if (Sentry::getUser()->hasAccess('form.update'))
											<div class="col-6">
												<p><a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$field->id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
											</div>
										@endif

										@if (Sentry::getUser()->hasAccess('form.delete'))
											<div class="col-6">
												<p><a href="#" class="btn btn-block btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $field->id }}">{{ $_icons['remove'] }}</a></p>
											</div>
										@endif
									</div>
								</div>
							</div>
						</div>
					@endforeach
					</div>
				@endif

				@if (array_key_exists('sections', $t))
					@foreach ($t['sections'] as $section)
						<legend>{{ $section->name }}</legend>

						<div class="nv-data-table nv-data-table-striped nv-data-table-bordered sortableFields">
						@foreach ($section->fields as $field)
							<div class="row" id="field_{{ $field->id }}">
								<div class="col-12 col-sm-8 col-lg-9">
									<div class="row">
										<div class="{{ $field->html_container_class }}">
											<div class="control-group">
												<label class="control-label">
													{{ $field->label }}
													@if ($field->status === Status::INACTIVE)
														<span class="label label-danger">({{ lang('Inactive') }})</span>
													@endif
												</label>
												<div class="controls">
													@if ($field->type == 'text')
														{{ Form::text($field->id, $field->value, ['placeholder' => $field->placeholder]) }}
													@elseif ($field->type == 'textarea')
														{{ Form::textarea($field->id, $field->value, ['placeholder' => $field->placeholder, 'rows' => $field->html_rows]) }}
													@elseif ($field->type == 'select')
														{{ Form::select($field->id, $field->getValues(), $field->value) }}
													@endif
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-12 col-sm-4 col-lg-3">
									<div class="hidden-sm">
										<div class="btn-toolbar pull-right">
											@if (Sentry::getUser()->hasAccess('form.update'))
												<div class="btn-group">
													<a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$field->id) }}" class="btn btn-small btn-default icn-size-16">{{ $_icons['edit'] }}</a>
												</div>
											@endif

											@if (Sentry::getUser()->hasAccess('form.delete'))
												<div class="btn-group">
													<a href="#" class="btn btn-small btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $field->id }}">{{ $_icons['remove'] }}</a>
												</div>
											@endif
										</div>
									</div>
									<div class="visible-sm">
										<div class="row">
											@if (Sentry::getUser()->hasAccess('form.update'))
												<div class="col-6">
													<p><a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$field->id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
												</div>
											@endif

											@if (Sentry::getUser()->hasAccess('form.delete'))
												<div class="col-6">
													<p><a href="#" class="btn btn-block btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $field->id }}">{{ $_icons['remove'] }}</a></p>
												</div>
											@endif
										</div>
									</div>
								</div>
							</div>
						@endforeach
						</div>
					@endforeach
				@endif

				@if ( ! array_key_exists('fields', $t) and ! array_key_exists('sections', $t))
					{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('form fields'))]) }}
				@endif
			</div>
		@endforeach
	</div>
@else
	@if (count($sections) > 0)
		@foreach ($sections as $s)
			<legend>{{ $s['section']->name }}</legend>

			<div class="nv-data-table nv-data-table-striped nv-data-table-bordered sortableFields">
			@foreach ($s['fields'] as $field)
				<div class="row" id="field_{{ $field->id }}">
					<div class="col-12 col-sm-8 col-lg-9">
						<div class="row">
							<div class="{{ $field->html_container_class }}">
								<div class="control-group">
									<label class="control-label">
										{{ $field->label }}
										@if ($field->status === Status::INACTIVE)
											<span class="label label-danger">({{ lang('Inactive') }})</span>
										@endif
									</label>
									<div class="controls">
										@if ($field->type == 'text')
											{{ Form::text($field->id, $field->value, ['placeholder' => $field->placeholder]) }}
										@elseif ($field->type == 'textarea')
											{{ Form::textarea($field->id, $field->value, ['placeholder' => $field->placeholder, 'rows' => $field->html_rows]) }}
										@elseif ($field->type == 'select')
											{{ Form::select($field->id, $field->getValues(), $field->value) }}
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-sm-4 col-lg-3">
						<div class="hidden-sm">
							<div class="btn-toolbar pull-right">
								@if (Sentry::getUser()->hasAccess('form.update'))
									<div class="btn-group">
										<a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$field->id) }}" class="btn btn-small btn-default icn-size-16">{{ $_icons['edit'] }}</a>
									</div>
								@endif

								@if (Sentry::getUser()->hasAccess('form.delete'))
									<div class="btn-group">
										<a href="#" class="btn btn-small btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $field->id }}">{{ $_icons['remove'] }}</a>
									</div>
								@endif
							</div>
						</div>
						<div class="visible-sm">
							<div class="row">
								@if (Sentry::getUser()->hasAccess('form.update'))
									<div class="col-6">
										<p><a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$field->id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
									</div>
								@endif

								@if (Sentry::getUser()->hasAccess('form.delete'))
									<div class="col-6">
										<p><a href="#" class="btn btn-block btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $field->id }}">{{ $_icons['remove'] }}</a></p>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			@endforeach
			</div>
		@endforeach
	@else
		@if (count($fields) > 0)
			<div class="nv-data-table nv-data-table-striped nv-data-table-bordered" id="sortableFields">
				@foreach ($fields as $f)
					<div class="row" id="field_{{ $f['field']->id }}">
						<div class="col-12 col-sm-8 col-lg-9">
							<div class="row">
								<div class="{{ $f['field']->html_container_class }}">
									<div class="control-group">
										<label class="control-label">
											{{ $f['field']->label }}
											@if ($f['field']->status === Status::INACTIVE)
												<span class="label label-danger">({{ lang('Inactive') }})</span>
											@endif
										</label>
										<div class="controls">
											@if ($f['field']->type == 'text')
												{{ Form::text($f['field']->id, $f['field']->value, ['placeholder' => $f['field']->placeholder]) }}
											@elseif ($f['field']->type == 'textarea')
												{{ Form::textarea($f['field']->id, $f['field']->value, ['placeholder' => $f['field']->placeholder, 'rows' => $f['field']->html_rows]) }}
											@elseif ($f['field']->type == 'select')
												{{ Form::select($f['field']->id, $f['field']->getValues(), $f['field']->value) }}
											@endif
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-4 col-lg-3">
							<div class="hidden-sm">
								<div class="btn-toolbar pull-right">
									@if (Sentry::getUser()->hasAccess('form.update'))
										<div class="btn-group">
											<a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$f['field']->id) }}" class="btn btn-small btn-default icn-size-16">{{ $_icons['edit'] }}</a>
										</div>
									@endif

									@if (Sentry::getUser()->hasAccess('form.delete'))
										<div class="btn-group">
											<a href="#" class="btn btn-small btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $f['field']->id }}">{{ $_icons['remove'] }}</a>
										</div>
									@endif
								</div>
							</div>
							<div class="visible-sm">
								<div class="row">
									@if (Sentry::getUser()->hasAccess('form.update'))
										<div class="col-6">
											<p><a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$f['field']->id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
										</div>
									@endif

									@if (Sentry::getUser()->hasAccess('form.delete'))
										<div class="col-6">
											<p><a href="#" class="btn btn-block btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $f['field']->id }}">{{ $_icons['remove'] }}</a></p>
										</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				@endforeach
			</div>
		@else
			{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('form fields'))]) }}
		@endif
	@endif
@endif