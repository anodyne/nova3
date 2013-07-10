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

@if ($tabs !== false)
	<ul class="nav nav-tabs">
	@foreach ($tabs as $tab)
		<li><a href="#{{ $tab->link_id }}" data-toggle="tab">{{ $tab->name }}</a></li>
	@endforeach
	</ul>

	<div class="tab-content">
	@foreach ($tabs as $tab)
		<div id="{{ $tab->link_id }}" class="tab-pane">
		@if ($sections !== false and isset($sections[$tab->id]))
			@foreach ($sections[$tab->id] as $section)
				<legend>{{ $section->name }}</legend>

				@if ($fields !== false and isset($fields[$section->id]))
					<div class="nv-data-table nv-data-table-striped nv-data-table-bordered" id="sortableFields">
						@foreach ($fields[$section->id] as $f)
							<div class="row" id="field_{{ $f->id }}">
								<div class="col-12 col-sm-8 col-lg-9">
									<div class="row">
										<div class="{{ $f->html_class }}">
											<div class="control-group">
												<label class="control-label">
													{{ $f->label }}
													@if ($f->status === Status::INACTIVE)
														<span class="label label-danger">({{ lang('Inactive') }})</span>
													@endif
												</label>
												<div class="controls">
													@if ($f->type == 'text')
														{{ Form::text($f->html_name, $f->value, ['placeholder' => $f->placeholder]) }}
													@elseif ($f->type == 'textarea')
														{{ Form::textarea($f->html_name, $f->value, ['placeholder' => $f->placeholder, 'rows' => $f->html_rows]) }}
													@elseif ($f->type == 'select')
														{{ Form::select($f->html_name, $f->getValues(), $f->value) }}
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
													<a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$f->id) }}" class="btn btn-small btn-default icn-size-16">{{ $_icons['edit'] }}</a>
												</div>
											@endif

											@if (Sentry::getUser()->hasAccess('form.delete'))
												<div class="btn-group">
													<a href="#" class="btn btn-small btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $f->id }}">{{ $_icons['remove'] }}</a>
												</div>
											@endif
										</div>
									</div>
									<div class="visible-sm">
										<div class="row">
											@if (Sentry::getUser()->hasAccess('form.update'))
												<div class="col-6">
													<p><a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$f->id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
												</div>
											@endif

											@if (Sentry::getUser()->hasAccess('form.delete'))
												<div class="col-6">
													<p><a href="#" class="btn btn-block btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $f->id }}">{{ $_icons['remove'] }}</a></p>
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
			@endforeach
		@else
			{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('form sections'))]) }}
		@endif
		</div>
	@endforeach
	</div>
@else
	@if ($sections !== false)
		@foreach ($sections as $section)
			<legend>{{ $section->name }}</legend>

			@if ($fields !== false and isset($fields[$section->id]))
				<div class="nv-data-table nv-data-table-striped nv-data-table-bordered" id="sortableFields">
					@foreach ($fields[$section->id] as $f)
						<div class="row" id="field_{{ $f->id }}">
							<div class="col-12 col-sm-8 col-lg-9">
								<div class="row">
									<div class="{{ $f->html_class }}">
										<div class="control-group">
											<label class="control-label">
												{{ $f->label }}
												@if ($f->status === Status::INACTIVE)
													<span class="label label-danger">({{ lang('Inactive') }})</span>
												@endif
											</label>
											<div class="controls">
												@if ($f->type == 'text')
													{{ Form::text($f->html_name, $f->value, ['placeholder' => $f->placeholder]) }}
												@elseif ($f->type == 'textarea')
													{{ Form::textarea($f->html_name, $f->value, ['placeholder' => $f->placeholder, 'rows' => $f->html_rows]) }}
												@elseif ($f->type == 'select')
													{{ Form::select($f->html_name, $f->getValues(), $f->value) }}
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
												<a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$f->id) }}" class="btn btn-small btn-default icn-size-16">{{ $_icons['edit'] }}</a>
											</div>
										@endif

										@if (Sentry::getUser()->hasAccess('form.delete'))
											<div class="btn-group">
												<a href="#" class="btn btn-small btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $f->id }}">{{ $_icons['remove'] }}</a>
											</div>
										@endif
									</div>
								</div>
								<div class="visible-sm">
									<div class="row">
										@if (Sentry::getUser()->hasAccess('form.update'))
											<div class="col-6">
												<p><a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$f->id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
											</div>
										@endif

										@if (Sentry::getUser()->hasAccess('form.delete'))
											<div class="col-6">
												<p><a href="#" class="btn btn-block btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $f->id }}">{{ $_icons['remove'] }}</a></p>
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
		@endforeach
	@else
		@if ($fields !== false)
			<div class="nv-data-table nv-data-table-striped nv-data-table-bordered" id="sortableFields">
				@foreach ($fields as $f)
					<div class="row" id="field_{{ $f->id }}">
						<div class="col-12 col-sm-8 col-lg-9">
							<div class="row">
								<div class="{{ $f->html_class }}">
									<div class="control-group">
										<label class="control-label">
											{{ $f->label }}
											@if ($f->status === Status::INACTIVE)
												<span class="label label-danger">({{ lang('Inactive') }})</span>
											@endif
										</label>
										<div class="controls">
											@if ($f->type == 'text')
												{{ Form::text($f->html_name, $f->value, ['placeholder' => $f->placeholder]) }}
											@elseif ($f->type == 'textarea')
												{{ Form::textarea($f->html_name, $f->value, ['placeholder' => $f->placeholder, 'rows' => $f->html_rows]) }}
											@elseif ($f->type == 'select')
												{{ Form::select($f->html_name, $f->getValues(), $f->value) }}
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
											<a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$f->id) }}" class="btn btn-small btn-default icn-size-16">{{ $_icons['edit'] }}</a>
										</div>
									@endif

									@if (Sentry::getUser()->hasAccess('form.delete'))
										<div class="btn-group">
											<a href="#" class="btn btn-small btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $f->id }}">{{ $_icons['remove'] }}</a>
										</div>
									@endif
								</div>
							</div>
							<div class="visible-sm">
								<div class="row">
									@if (Sentry::getUser()->hasAccess('form.update'))
										<div class="col-6">
											<p><a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$f->id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
										</div>
									@endif

									@if (Sentry::getUser()->hasAccess('form.delete'))
										<div class="col-6">
											<p><a href="#" class="btn btn-block btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $f->id }}">{{ $_icons['remove'] }}</a></p>
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