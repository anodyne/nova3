<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/form') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>

	@if ($_currentUser->hasAccess('form.create'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/form/fields/'.$formKey.'/0') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
		</div>
	@endif

	<div class="btn-group">
		<a href="{{ URL::to('admin/form/tabs/'.$formKey) }}" class="btn btn-default icn-size-16-with-text">{{ lang('Tabs') }}</a>
		<a href="{{ URL::to('admin/form/sections/'.$formKey) }}" class="btn btn-default icn-size-16-with-text">{{ lang('Sections') }}</a>
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
							<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
								<div class="row">
									<div class="{{ $field->html_container_class }}">
										<div class="form-group">
											<label class="control-label">
												{{ $field->label }}
												@if ($field->status === Status::INACTIVE)
													<span class="label label-danger">({{ lang('Inactive') }})</span>
												@endif
											</label>
											@if ($field->type == 'text')
												{{ Form::text($field->id, $field->value, ['placeholder' => $field->placeholder, 'class' => 'form-control']) }}
											@elseif ($field->type == 'textarea')
												{{ Form::textarea($field->id, $field->value, ['placeholder' => $field->placeholder, 'rows' => $field->html_rows, 'class' => 'form-control']) }}
											@elseif ($field->type == 'select')
												{{ Form::select($field->id, $field->getValues(), $field->value, ['class' => 'form-control']) }}
											@endif
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
								<div class="visible-md visible-lg">
									<div class="btn-toolbar pull-right">
										@if ($_currentUser->hasAccess('form.update'))
											<div class="btn-group">
												<a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$field->id) }}" class="btn btn-sm btn-default icn-size-16">{{ $_icons['edit'] }}</a>
											</div>
										@endif

										@if ($_currentUser->hasAccess('form.delete'))
											<div class="btn-group">
												<a href="#" class="btn btn-sm btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $field->id }}">{{ $_icons['remove'] }}</a>
											</div>
										@endif
									</div>
								</div>
								<div class="hidden-md hidden-lg">
									<div class="row">
										@if ($_currentUser->hasAccess('form.update'))
											<div class="col-xs-12 col-sm-6">
												<p><a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$field->id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
											</div>
										@endif

										@if ($_currentUser->hasAccess('form.delete'))
											<div class="col-xs-12 col-sm-6">
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
								<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
									<div class="row">
										<div class="{{ $field->html_container_class }}">
											<div class="form-group">
												<label class="control-label">
													{{ $field->label }}
													@if ($field->status === Status::INACTIVE)
														<span class="label label-danger">({{ lang('Inactive') }})</span>
													@endif
												</label>
												@if ($field->type == 'text')
													{{ Form::text($field->id, $field->value, ['placeholder' => $field->placeholder, 'class' => 'form-control']) }}
												@elseif ($field->type == 'textarea')
													{{ Form::textarea($field->id, $field->value, ['placeholder' => $field->placeholder, 'rows' => $field->html_rows, 'class' => 'form-control']) }}
												@elseif ($field->type == 'select')
													{{ Form::select($field->id, $field->getValues(), $field->value, ['class' => 'form-control']) }}
												@endif
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
									<div class="visible-md visible-lg">
										<div class="btn-toolbar pull-right">
											@if ($_currentUser->hasAccess('form.update'))
												<div class="btn-group">
													<a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$field->id) }}" class="btn btn-sm btn-default icn-size-16">{{ $_icons['edit'] }}</a>
												</div>
											@endif

											@if ($_currentUser->hasAccess('form.delete'))
												<div class="btn-group">
													<a href="#" class="btn btn-sm btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $field->id }}">{{ $_icons['remove'] }}</a>
												</div>
											@endif
										</div>
									</div>
									<div class="hidden-md hidden-lg">
										<div class="row">
											@if ($_currentUser->hasAccess('form.update'))
												<div class="col-xs-12 col-sm-6">
													<p><a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$field->id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
												</div>
											@endif

											@if ($_currentUser->hasAccess('form.delete'))
												<div class="col-xs-12 col-sm-6">
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
					<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
						<div class="row">
							<div class="{{ $field->html_container_class }}">
								<div class="form-group">
									<label class="control-label">
										{{ $field->label }}
										@if ($field->status === Status::INACTIVE)
											<span class="label label-danger">({{ lang('Inactive') }})</span>
										@endif
									</label>
									@if ($field->type == 'text')
										{{ Form::text($field->id, $field->value, ['placeholder' => $field->placeholder, 'class' => 'form-control']) }}
									@elseif ($field->type == 'textarea')
										{{ Form::textarea($field->id, $field->value, ['placeholder' => $field->placeholder, 'rows' => $field->html_rows, 'class' => 'form-control']) }}
									@elseif ($field->type == 'select')
										{{ Form::select($field->id, $field->getValues(), $field->value, ['class' => 'form-control']) }}
									@endif
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
						<div class="visible-md visible-lg">
							<div class="btn-toolbar pull-right">
								@if ($_currentUser->hasAccess('form.update'))
									<div class="btn-group">
										<a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$field->id) }}" class="btn btn-sm btn-default icn-size-16">{{ $_icons['edit'] }}</a>
									</div>
								@endif

								@if ($_currentUser->hasAccess('form.delete'))
									<div class="btn-group">
										<a href="#" class="btn btn-sm btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $field->id }}">{{ $_icons['remove'] }}</a>
									</div>
								@endif
							</div>
						</div>
						<div class="hidden-md hidden-lg">
							<div class="row">
								@if ($_currentUser->hasAccess('form.update'))
									<div class="col-xs-12 col-sm-6">
										<p><a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$field->id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
									</div>
								@endif

								@if ($_currentUser->hasAccess('form.delete'))
									<div class="col-xs-12 col-sm-6">
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
						<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
							<div class="row">
								<div class="{{ $f['field']->html_container_class }}">
									<div class="form-group">
										<label class="control-label">
											{{ $f['field']->label }}
											@if ($f['field']->status === Status::INACTIVE)
												<span class="label label-danger">({{ lang('Inactive') }})</span>
											@endif
										</label>
										@if ($field->type == 'text')
											{{ Form::text($field->id, $field->value, ['placeholder' => $field->placeholder, 'class' => 'form-control']) }}
										@elseif ($field->type == 'textarea')
											{{ Form::textarea($field->id, $field->value, ['placeholder' => $field->placeholder, 'rows' => $field->html_rows, 'class' => 'form-control']) }}
										@elseif ($field->type == 'select')
											{{ Form::select($field->id, $field->getValues(), $field->value, ['class' => 'form-control']) }}
										@endif
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
							<div class="visible-md visible-lg">
								<div class="btn-toolbar pull-right">
									@if ($_currentUser->hasAccess('form.update'))
										<div class="btn-group">
											<a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$f['field']->id) }}" class="btn btn-sm btn-default icn-size-16">{{ $_icons['edit'] }}</a>
										</div>
									@endif

									@if ($_currentUser->hasAccess('form.delete'))
										<div class="btn-group">
											<a href="#" class="btn btn-sm btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $f['field']->id }}">{{ $_icons['remove'] }}</a>
										</div>
									@endif
								</div>
							</div>
							<div class="hidden-md hidden-lg">
								<div class="row">
									@if ($_currentUser->hasAccess('form.update'))
										<div class="col-xs-12 col-sm-6">
											<p><a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$f['field']->id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
										</div>
									@endif

									@if ($_currentUser->hasAccess('form.delete'))
										<div class="col-xs-12 col-sm-6">
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

{{ modal(['id' => 'deleteField', 'header' => lang('Short.delete', langConcat('Form Field'))]) }}