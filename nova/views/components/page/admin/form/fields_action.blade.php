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
				<div class="col-sm-6 col-lg-3">
					<div class="form-group">
						<label class="control-label">{{ lang('Type') }}</label>
						{{ Form::select('type', ['text' => lang('Text_field'), 'textarea' => lang('Text_area'), 'select' => lang('Dropdown')], null, ['class' => 'form-control js-type-change']) }}
					</div>
				</div>
			</div>

			@if ($accessRoles->count() > 0)
				<div class="row">
					<div class="col-lg-6">
						<label class="control-label">{{ langConcat('Field Restrictions') }}</label>
						<div class="row">
						@foreach ($accessRoles as $role)
							<div class="col-sm-6 col-lg-6">
								<label class="checkbox">
									@if ($action == 'create')
										{{ Form::checkbox('restriction[]', $role->id) }} {{ $role->name }}
									@else
										{{ Form::checkbox('restriction[]', $role->id, (in_array($role->id, $field->restriction))) }} {{ $role->name }}
									@endif
								</label>
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
									{{ Form::radio('associate', 'tab', false, ['class' => 'js-associate-change']) }}
								@else
									{{ Form::radio('associate', 'tab', ($field->tab_id > 0 and $field->section_id == 0), ['class' => 'js-associate-change']) }}
								@endif

								{{ lang('Tab') }}
							</label>
							<label class="radio-inline">
								@if ($action == 'create')
									{{ Form::radio('associate', 'section', true, ['class' => 'js-associate-change']) }}
								@else
									{{ Form::radio('associate', 'section', ($field->tab_id == 0 and $field->section_id > 0), ['class' => 'js-associate-change']) }}
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
				<div class="row{{ isset($sectionsAndTabs) ? ' hidden' : '' }}" id="associateSection">
					<div class="col-sm-6 col-lg-4">
						<div class="form-group">
							<label class="control-label">{{ lang('Section') }}</label>
							{{ Form::select('section_id', $sections, null, ['class' => 'form-control']) }}
						</div>
					</div>
				</div>
			@endif

			@if (count($tabs) > 0)
				<div class="row{{ isset($sectionsAndTabs) ? ' hidden' : '' }}" id="associateTab">
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
				<div class="row field-value-list hidden">
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

			<div class="row field-rows hidden">
				<div class="col-sm-4 col-lg-2">
					<div class="form-group">
						<label class="control-label">{{ lang('Rows') }}</label>
						{{ Form::text('html_rows', null, ['class' => 'form-control']) }}
					</div>
				</div>
			</div>
		</div>
		
		@if ($action == 'update')
			<div class="tab-pane" id="values">
				<p>{{ lang('short.admin.forms.dropdownUpdate', '<span class="icn-size-16">'.$_icons['add'].'</span>', '<span class="icn-size-16">'.$_icons['check'].'</span>', '<span class="icn-size-16">'.$_icons['remove'].'</span>') }}</p>
				
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
									{{ partial('forms/field_value', ['value' => $v->value, 'id' => $v->id, 'icons' => $_icons]) }}
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
			{{ Form::hidden('id') }}
			{{ Form::hidden('formAction', $action) }}
			{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
		</div>
	</div>
{{ Form::close() }}