<div class="visible-lg">
	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ URL::to('admin/form/fields/'.$formKey) }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
		</div>
	</div>
</div>
<div class="hidden-lg">
	<div class="row">
		<div class="col-4">
			<p><a href="{{ URL::to('admin/form/fields/'.$formKey) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['back'] }}</a></p>
		</div>
	</div>
</div>

<div class="hidden-sm">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#general" data-toggle="tab">{{ langConcat('General Attributes') }}</a></li>
		<li><a href="#html" data-toggle="tab">{{ langConcat('html Attributes') }}</a></li>
		@if ($action == 'update')
			<li><a href="#values" data-toggle="tab">{{ lang('Values') }}</a></li>
		@endif
	</ul>
</div>
<div class="visible-sm">
	<ul class="nav nav-pills">
		<li class="active"><a href="#general" data-toggle="tab">{{ langConcat('General Attributes') }}</a></li>
		<li><a href="#html" data-toggle="tab">{{ langConcat('html Attributes') }}</a></li>
		@if ($action == 'update')
			<li><a href="#values" data-toggle="tab">{{ lang('Values') }}</a></li>
		@endif
	</ul>
</div>

{{ Form::model($field, ['url' => 'admin/form/fields/'.$formKey]) }}
	<div class="tab-content">
		<div class="tab-pane active" id="general">
			<div class="row">
				<div class="col-sm-4 col-lg-2">
					<div class="control-group">
						<label class="control-label">{{ lang('Type') }}</label>
						<div class="controls">
							{{ Form::select('type', $types) }}
						</div>
					</div>
				</div>
			</div>

			@if ($accessRoles->count() > 0)
				<div class="row">
					<div class="col-lg-6">
						<label class="control-label">{{ langConcat('Field Restrictions') }}</label>
						<div class="controls">
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
						</div>

						<p class="help-block">{{ lang('short.admin.forms.fieldRestriction') }}</p>
					</div>
				</div>
			@endif

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<div class="control-group">
						<label class="control-label">{{ lang('Label') }}</label>
						<div class="controls">
							{{ Form::text('label') }}
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-8 col-lg-6">
					<div class="control-group">
						<label class="control-label">{{ ucwords(lang('inline_help')) }}</label>
						<div class="controls">
							{{ Form::textarea('help', null, ['rows' => 2]) }}
						</div>
					</div>
				</div>
			</div>

			@if (count($sections) > 0)
				<div class="row">
					<div class="col-sm-6 col-lg-4">
						<div class="control-group">
							<label class="control-label">{{ lang('Section') }}</label>
							<div class="controls">
								{{ Form::select('section_id', $sections) }}
							</div>
						</div>
					</div>
				</div>
			@endif

			<div class="row">
				<div class="col-sm-2 col-lg-2">
					<label class="control-label">{{ lang('Order') }}</label>
					<div class="controls">
						{{ Form::text('order') }}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="help-block">{{ lang('short.admin.forms.order') }}</p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<div class="control-group">
						<label class="control-label">{{ lang('Display') }}</label>
						<div class="controls">
							<label class="radio-inline">{{ Form::radio('status', Status::ACTIVE) }} {{ lang('Yes') }}</label>
							<label class="radio-inline">{{ Form::radio('status', Status::INACTIVE) }} {{ lang('No') }}</label>
						</div>
					</div>
				</div>
			</div>

			@if ($action == 'create')
				<div class="row field-value-list hide">
					<div class="col-sm-8 col-lg-6">
						<div class="control-group">
							<label class="control-label">{{ ucwords(langConcat('dropdown values')) }}</label>
							<div class="controls">
								{{ Form::textarea('field_values', null, ['rows' => 4]) }}
								<p class="help-block">{{ lang('short.admin.forms.dropdownCreation') }}</p>
							</div>
						</div>
					</div>
				</div>
			@endif
		</div>

		<div class="tab-pane" id="html">
			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<div class="control-group">
						<label class="control-label">{{ lang('id') }}</label>
						<div class="controls">
							{{ Form::text('html_id') }}
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<div class="control-group">
						<label class="control-label">{{ lang('Class') }}</label>
						<div class="controls">
							{{ Form::text('html_class') }}
						</div>
					</div>
				</div>
			</div>

			<div class="row field-placeholder">
				<div class="col-sm-6 col-lg-4">
					<div class="control-group">
						<label class="control-label">{{ lang('Placeholder') }}</label>
						<div class="controls">
							{{ Form::text('placeholder') }}
						</div>
					</div>
				</div>
			</div>

			<div class="row field-value">
				<div class="col-sm-6 col-lg-4">
					<div class="control-group">
						<label class="control-label">{{ lang('Value') }}</label>
						<div class="controls">
							{{ Form::text('value') }}
						</div>
					</div>
				</div>
			</div>

			<div class="row field-rows hide">
				<div class="col-sm-4 col-lg-2">
					<div class="control-group">
						<label class="control-label">{{ lang('Rows') }}</label>
						<div class="controls">
							{{ Form::text('html_rows') }}
						</div>
					</div>
				</div>
			</div>
		</div>
		
		@if ($action == 'update')
			{{-- If the values table is updated, ajax/add/postFormValue has to be updated too --}}
			<div class="tab-pane" id="values">
				<div class="row">
					<div class="col-lg-6">
						<p>{{ lang('short.admin.forms.dropdownUpdate', '<span class="text-success">'.$_icons['add'].'</span>', '<span class="text-success">'.$_icons['check'].'</span>', '<span class="text-danger">'.$_icons['remove'].'</span>') }}</p>

						<div class="row">
							<div class="col-9 col-sm-6 col-lg-7">
								{{ Form::text('value-add-content', null, ['placeholder' => lang('Short.add', langConcat('Field Values')), 'class' => 'icn-size-16']) }}
							</div>
							<div class="col-lg-1">
								{{ Form::button($_icons['add'], ['class' => 'btn btn-default icn-size-16 js-value-action', 'data-action' => 'add']) }}
							</div>
						</div>

						<table class="table table-bordered table-striped sort-value">
							<tbody class="sort-body">
							@if (count($values) == 0)
								<tr>
									<td colspan="3">
										<strong class="muted">{{ lang('error.notFound', langConcat('field values')) }}</strong>
									</td>
								</tr>
							@else
								@foreach ($values as $v)
									<tr id="value_{{ $v->id }}">
										<td>
											<div class="row">
												<div class="col-12 col-sm-9 col-lg-9">
													{{ Form::text('', $v->value) }}
												</div>
												<div class="col-6 col-sm-1 col-lg-1">
													<div class="hidden-sm">
														<a href="#" class="btn btn-small btn-default js-value-action icn-size-16 tooltip-top" title="{{ lang('Action.save') }}" data-action="update" data-id="{{ $v->id }}">{{ $_icons['check'] }}</a>
													</div>
													<div class="visible-sm">
														<p><a href="#" class="btn btn-small btn-block btn-default js-value-action icn-size-16" data-action="update" data-id="{{ $v->id }}">{{ $_icons['check'] }}</a></p>
													</div>
												</div>
												<div class="col-6 col-sm-1 col-lg-1">
													<div class="hidden-sm">
														<a href="#" class="btn btn-small btn-danger js-value-action icn-size-16" data-action="delete" data-id="{{ $v->id }}">{{ $_icons['remove'] }}</a>
													</div>
													<div class="visible-sm">
														<p><a href="#" class="btn btn-small btn-block btn-danger js-value-action icn-size-16" data-action="delete" data-id="{{ $v->id }}">{{ $_icons['remove'] }}</a></p>
													</div>
												</div>
												<div class="col-lg-1 visible-lg">
													<div class="reorder-small icn-size-16 icn-opacity-50 text-center">{{ $_icons['move'] }}</div>
												</div>
											</div>
										</td>
									</tr>
								@endforeach
							@endif
							</tbody>
						</table>
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