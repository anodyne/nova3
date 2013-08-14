<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/form/fields/'.$formKey) }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>
</div>

<ul class="nav nav-tabs">
	<li class="active"><a href="#general" data-toggle="tab">{{ langConcat('General Attributes') }}</a></li>
	<li><a href="#html" data-toggle="tab">{{ langConcat('html Attributes') }}</a></li>
	@if ($action == 'update')
		<li><a href="#values" data-toggle="tab">{{ lang('Values') }}</a></li>
	@endif
</ul>

{{ Form::model($field, ['url' => 'admin/form/fields/'.$formKey]) }}
	<div class="tab-content">
		<div class="tab-pane active" id="general">
			<div class="row">
				<div class="col-sm-4 col-lg-2">
					<div class="form-group">
						<label class="control-label">{{ lang('Type') }}</label>
						{{ Form::select('type', $types, null, ['class' => 'form-control']) }}
					</div>
				</div>
			</div>

			@if ($accessRoles->count() > 0)
				<div class="row">
					<div class="col-lg-6">
						<label class="control-label">{{ langConcat('Field Restrictions') }}</label>
						<div class="row">
						@foreach ($accessRoles as $role)
							<div class="col-lg-6">
								<div class="controls">
									<label class="checkbox">
										@if ($action == 'create')
											{{ Form::checkbox('restriction[]', $role->id) }} {{ $role->name }}
										@else
											{{ Form::checkbox('restriction[]', $role->id, (in_array($role->id, $field->restriction))) }} {{ $role->name }}
										@endif
									</label>
								</div>
							</div>
						@endforeach
						</div>

						<p class="help-block">{{ lang('short.admin.forms.fieldRestriction') }}</p>
					</div>
				</div>
			@endif

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<div class="form-group">
						<label class="control-label">{{ lang('Label') }}</label>
						{{ Form::text('label', null, ['class' => 'form-control']) }}
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-8 col-lg-6">
					<div class="form-group">
						<label class="control-label">{{ ucwords(lang('inline_help')) }}</label>
						{{ Form::textarea('help', null, ['rows' => 3, 'class' => 'form-control']) }}
					</div>
				</div>
			</div>

			@if (count($sections) > 0 and count($tabs) > 0)
				<?php $sectionsAndTabs = true;?>
				<div class="row">
					<div class="col-sm-6 col-lg-4">
						<label class="control-label">{{ lang('short.admin.forms.associateField') }}</label>
						<div>
							<label class="radio-inline">
								@if ($action == 'create')
									{{ Form::radio('associate', 'tab') }}
								@else
									{{ Form::radio('associate', 'tab', ($field->tab_id > 0 and $field->section_id == 0)) }}
								@endif

								{{ lang('Tab') }}
							</label>
							<label class="radio-inline">
								@if ($action == 'create')
									{{ Form::radio('associate', 'section', true) }}
								@else
									{{ Form::radio('associate', 'section', ($field->tab_id == 0 and $field->section_id > 0)) }}
								@endif

								{{ lang('Section') }}
							</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<p class="help-block">{{ lang('short.admin.forms.associateFieldHelp') }}</p>
					</div>
				</div>
			@endif

			@if (count($sections) > 0)
				<div class="row{{ isset($sectionsAndTabs) ? ' hide' : '' }}" id="associateSection">
					<div class="col-sm-6 col-lg-4">
						<div class="form-group">
							<label class="control-label">{{ lang('Section') }}</label>
							{{ Form::select('section_id', $sections, null, ['class' => 'form-control']) }}
						</div>
					</div>
				</div>
			@endif

			@if (count($tabs) > 0)
				<div class="row{{ isset($sectionsAndTabs) ? ' hide' : '' }}" id="associateTab">
					<div class="col-sm-6 col-lg-4">
						<div class="form-group">
							<label class="control-label">{{ lang('Tab') }}</label>
							{{ Form::select('tab_id', $tabs, null, ['class' => 'form-control']) }}
						</div>
					</div>
				</div>
			@endif

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<label class="control-label">{{ lang('Validation') }}</label>
					{{ Form::text('validation_rules', null, ['class' => 'form-control']) }}
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="help-block">{{ lang('short.admin.forms.validation') }}</p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-2 col-lg-2">
					<label class="control-label">{{ lang('Order') }}</label>
					{{ Form::text('order', null, ['class' => 'form-control']) }}
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="help-block">{{ lang('short.admin.forms.order') }}</p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<div class="form-group">
						<label class="control-label">{{ lang('Display') }}</label>
						<div>
							<label class="radio-inline">{{ Form::radio('status', Status::ACTIVE) }} {{ lang('Yes') }}</label>
							<label class="radio-inline">{{ Form::radio('status', Status::INACTIVE) }} {{ lang('No') }}</label>
						</div>
					</div>
				</div>
			</div>

			@if ($action == 'create')
				<div class="row field-value-list hide">
					<div class="col-sm-8 col-lg-6">
						<div class="form-group">
							<label class="control-label">{{ ucwords(langConcat('dropdown values')) }}</label>
							{{ Form::textarea('field_values', null, ['rows' => 5, 'class' => 'form-control']) }}
							<p class="help-block">{{ lang('short.admin.forms.dropdownCreation') }}</p>
						</div>
					</div>
				</div>
			@endif
		</div>

		<div class="tab-pane" id="html">
			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<label class="control-label">{{ langConcat('Container Class') }}</label>
					{{ Form::text('html_container_class', null, ['class' => 'form-control']) }}
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="help-block">{{ lang('short.admin.forms.containerClass') }}</p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<div class="form-group">
						<label class="control-label">{{ lang('id') }}</label>
						{{ Form::text('html_id', null, ['class' => 'form-control']) }}
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<div class="form-group">
						<label class="control-label">{{ lang('Class') }}</label>
						{{ Form::text('html_class', null, ['class' => 'form-control']) }}
					</div>
				</div>
			</div>

			<div class="row field-placeholder">
				<div class="col-sm-6 col-lg-4">
					<div class="form-group">
						<label class="control-label">{{ lang('Placeholder') }}</label>
						{{ Form::text('placeholder', null, ['class' => 'form-control']) }}
					</div>
				</div>
			</div>

			<div class="row field-value">
				<div class="col-sm-6 col-lg-4">
					<div class="form-group">
						<label class="control-label">{{ lang('Value') }}</label>
						{{ Form::text('value', null, ['class' => 'form-control']) }}
					</div>
				</div>
			</div>

			<div class="row field-rows hide">
				<div class="col-sm-4 col-lg-2">
					<div class="form-group">
						<label class="control-label">{{ lang('Rows') }}</label>
						{{ Form::text('html_rows', null, ['class' => 'form-control']) }}
					</div>
				</div>
			</div>
		</div>
		
		@if ($action == 'update')
			{{-- If the values table is updated, ajax/add/postFormValue has to be updated too --}}
			<div class="tab-pane" id="values">
				<p>{{ lang('short.admin.forms.dropdownUpdate', '<span class="text-success">'.$_icons['add'].'</span>', '<span class="text-success">'.$_icons['check'].'</span>', '<span class="text-danger">'.$_icons['remove'].'</span>') }}</p>
				
				<div class="row">
					<div class="col-lg-6">
						<div class="row">
							<div class="col-9 col-sm-6 col-lg-7">
								{{ Form::text('value-add-content', null, ['placeholder' => lang('Short.add', langConcat('Field Values')), 'class' => 'icn-size-16 form-control']) }}
							</div>
							<div class="col-1 col-lg-1">
								{{ Form::button($_icons['add'], ['class' => 'btn btn-sm btn-default icn-size-16 js-value-action', 'data-action' => 'add']) }}
							</div>
						</div>

						@if (count($values) > 0)
							<div class="nv-data-table nv-data-table-striped nv-data-table-bordered" id="sortableValues">
								@foreach ($values as $v)
									<div class="row">
										<div class="col-xs-12 col-sm-8 col-lg-8">
											<p>{{ Form::text('', $v->value, ['class' => 'form-control']) }}</p>
										</div>
										<div class="col-xs-6 col-sm-2 col-lg-2">
											<div class="hidden-xs">
												<p class="pull-right"><a href="#" class="btn btn-sm btn-default js-value-action icn-size-16 tooltip-top" title="{{ lang('Action.save') }}" data-action="update" data-id="{{ $v->id }}">{{ $_icons['check'] }}</a></p>
											</div>
											<div class="visible-xs">
												<p><a href="#" class="btn btn-block btn-default js-value-action icn-size-16" data-action="update" data-id="{{ $v->id }}">{{ $_icons['check'] }}</a></p>
											</div>
										</div>
										<div class="col-xs-6 col-sm-2 col-lg-2">
											<div class="hidden-xs">
												<p><a href="#" class="btn btn-sm btn-danger js-value-action icn-size-16" data-action="delete" data-id="{{ $v->id }}">{{ $_icons['remove'] }}</a></p>
											</div>
											<div class="visible-xs">
												<p><a href="#" class="btn btn-block btn-danger js-value-action icn-size-16" data-action="delete" data-id="{{ $v->id }}">{{ $_icons['remove'] }}</a></p>
											</div>
										</div>
									</div>
								@endforeach
							</div>
						@else
							{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('field values'))]) }}
						@endif
					</div>
				</div>
			</div>
		@endif
	</div>

	<div class="row">
		<div class="col-lg-12">
			{{ Form::token() }}
			{{ Form::hidden('id') }}
			{{ Form::hidden('action', $action) }}
			{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
		</div>
	</div>
{{ Form::close() }}