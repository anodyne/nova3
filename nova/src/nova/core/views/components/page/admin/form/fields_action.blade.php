<div class="btn-group">
	<a href="{{ URL::to('admin/form/fields/'.$formKey) }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
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
					<div class="control-group">
						<label class="control-label">{{ lang('Type') }}</label>
						<div class="controls">
							{{ Form::select('type', $types) }}
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<label class="control-label">{{ lang('Restrictions') }}</label>
					<div class="controls">
						{{ Form::select('restriction', $types) }}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="help-block">{{ lang('short.admin.forms.fieldRestriction') }}</p>
				</div>
			</div>

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
				<div class="col-sm-4 col-lg-2">
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
		</div>

		<div class="tab-pane" id="html">
			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<div class="control-group">
						<label class="control-label">{{ lang('Name') }}</label>
						<div class="controls">
							{{ Form::text('html_name') }}
						</div>
					</div>
				</div>
			</div>

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
						<div class="row">
							<div class="col-lg-6 input-group">
								{{ Form::text('value-add-content', null, ['placeholder' => lang('Short.add', langConcat('Field Values')), 'class' => 'icn-size-16']) }}
								<span class="input-group-btn">
									{{ Form::button($_icons['add'], ['class' => 'btn btn-default icn-size-16 js-value-action', 'data-action' => 'add']) }}
								</span>
							</div>
						</div>

						<table class="table table-striped sort-value">
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
											<div class="input-group">
												{{ Form::text('', $v->content, ['class' => 'icn-size-16']) }}
												<span class="input-group-btn">
													<a href="#" class="btn btn-default js-value-action icn-size-16 tooltip-top" title="{{ lang('Action.save') }}" data-action="update" data-id="{{ $v->id }}">{{ $_icons['check'] }}</a>

													<a href="#" class="btn btn-danger js-value-action icn-size-16" data-action="delete" data-id="{{ $v->id }}">{{ $_icons['remove'] }}</a>
												</span>
											</div>
										</td>
										<td class="col-alt-1">
											<div class="reorder icn-size-16 icn-opacity-50">{{ $_icons['move'] }}</div>
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

	{{ Form::token() }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('action', $action) }}
	{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}