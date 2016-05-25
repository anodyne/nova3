<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.forms.fields', [$form->key]) }}" class="btn btn-default btn-lg btn-block">{!! icon('arrow-back') !!}<span>Back to Form Fields</span></a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.forms.fields', [$form->key]) }}" class="btn btn-default">{!! icon('arrow-back') !!}<span>Back to Form Fields</span></a>
			</div>
		</div>
	</desktop>

	<div v-show="hasType">
		<h3>Live Preview</h3>

		<div class="well">
			@if ($form->orientation == 'horizontal')
				<div class="form-horizontal">
					<div class="form-group">
						<label class="control-label @{{ labelContainerClass }}" v-show="label != ''">@{{ label }}</label>
						<div class="@{{ fieldContainerClass }}">
							{!! partial('form/field-live-preview') !!}
							<p class="help-block" v-show="help != ''">@{{ help }}</p>
						</div>
					</div>
				</div>
			@else
				<div class="row">
					<div class="@{{ fieldContainerClass }}">
						<div class="form-group">
							<label class="control-label" v-show="label != ''">@{{ label }}</label>
							{!! partial('form/field-live-preview') !!}
							<p class="help-block" v-show="help != ''">@{{ help }}</p>
						</div>
					</div>
				</div>
			@endif
		</div>
	</div>

	<ul class="nav nav-pills">
		<li class="active"><a href="#basic" data-toggle="pill">{!! icon('info') !!} <span>Basic Info</span></a></li>
		<li v-show="hasType"><a href="#attributes" data-toggle="pill">{!! icon('settings') !!} <span>Attributes</span></a></li>
		<li v-show="hasType"><a href="#validation" data-toggle="pill">{!! icon('shield') !!} <span>Validation</span></a></li>
		<li v-show="hasValues"><a href="#values" data-toggle="pill">{!! icon('list') !!} <span>Values</span></a></li>
	</ul>

	{!! Form::model($field, ['route' => ['admin.forms.fields.update', $form->key, $field->id], 'class' => 'form-horizontal', 'method' => 'put']) !!}
		<div class="tab-content">
			<div id="basic" class="tab-pane active">
				<div class="form-group{{ ($errors->has('type')) ? ' has-error' : '' }}">
					<label class="col-md-2 control-label">Type</label>
					<div class="col-md-4">
						{!! Form::select('type', $fieldTypes, null, ['class' => 'form-control input-lg', 'placeholder' => "Please choose a field type", 'v-model' => 'type', '@change' => 'updateType']) !!}
						{!! $errors->first('type', '<p class="help-block">:message</p>') !!}
					</div>
				</div>

				<div v-show="hasType">
					<div class="form-group">
						<div class="col-md-10 col-md-offset-2">
							<h3>Field Info</h3>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label">Label</label>
						<div class="col-md-4">
							{!! Form::text('label', null, ['class' => 'form-control input-lg', 'v-model' => 'label']) !!}
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label">Field Size</label>
						<div class="col-md-3">
							{!! Form::select('field_container_class_select', $sizes, $field->field_container_class, ['class' => 'form-control input-lg', 'v-model' => 'fieldContainerClassSelect']) !!}
						</div>
						<div class="col-md-3" v-show="fieldContainerClassSelect == 'Custom'">
							{!! Form::text('field_container_class', null, ['class' => 'form-control input-lg', 'v-model' => 'fieldContainerClass']) !!}
						</div>
					</div>

					@if ($form->orientation == 'horizontal')
						<div class="form-group">
							<label class="col-md-2 control-label">Label Size</label>
							<div class="col-md-3">
								<p>{!! Form::select('label_container_class_select', $sizes, $field->label_container_class, ['class' => 'form-control input-lg', 'v-model' => 'labelContainerClassSelect']) !!}</p>
							</div>
							<div class="col-md-3" v-show="labelContainerClassSelect == 'Custom'">
								{!! Form::text('label_container_class', null, ['class' => 'form-control input-lg', 'v-model' => 'labelContainerClass']) !!}
							</div>
						</div>
					@endif

					<div class="form-group">
						<label class="col-md-2 control-label">Help Text</label>
						<div class="col-md-6">
							{!! Form::textarea('help', null, ['class' => 'form-control input-lg', 'rows' => 3, 'v-model' => 'help']) !!}
						</div>
					</div>

					<div class="form-group{{ ($errors->has('status')) ? ' has-error' : '' }}">
						<label class="col-md-2 control-label">Status</label>
						<div class="col-md-5">
							<div>
								<div class="radio">
									<label>{!! Form::radio('status', Status::ACTIVE, true, ['v-model' => 'status']) !!} {{ ucwords(Status::toString(Status::ACTIVE)) }}</label>
								</div>
								<div class="radio">
									<label>{!! Form::radio('status', Status::INACTIVE, false, ['v-model' => 'status']) !!} {{ ucwords(Status::toString(Status::INACTIVE)) }}</label>
								</div>
							</div>
							{!! $errors->first('status', '<p class="help-block">:message</p>') !!}
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-10 col-md-offset-2">
							<h3>Placement</h3>

							<p>Fields can be placed in several different ways. The most common area to place a field is within a section. You can also choose to place a field in a tab, but not in a section. Additionally, you can have fields outside of any tabs if you wish (unbound). Unbound fields will appear at the top of the form before any unbound sections or tabs.</p>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label">Form Tab</label>
						<div class="col-md-4">
							{!! Form::select('tab_id', $tabs, null, ['class' => 'form-control input-lg', 'v-model' => 'tabId']) !!}
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label">Form Section</label>
						<div class="col-md-4">
							{!! Form::select('section_id', $sections, null, ['class' => 'form-control input-lg', 'v-model' => 'sectionId']) !!}
							<p class="help-block">If you specify a section, you do not need to specify a tab.</p>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-10 col-md-offset-2">
							<h3>Restrictions</h3>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-8 col-lg-6 col-md-offset-2">
							<div class="data-table data-table-striped data-table-bordered">
								<div class="row">
									<div class="col-sm-2 col-md-3"><p><strong>Type</strong></p></div>
									<div class="col-sm-8 col-md-6"><p><strong>Value</strong></p></div>
									<div class="col-sm-2 col-md-3"></div>
								</div>
								<div class="row" v-for="restriction in restrictions">
									<div class="col-sm-2 col-md-3">
										<p>@{{ restriction.type | capitalize }}</p>
									</div>
									<div class="col-sm-8 col-md-6">
										<p>
											<select name="restrictionValues[@{{ restriction.type }}]" class="form-control" v-model="restriction.value">
												<option value="">No restriction</option>
												@foreach ($accessRoles as $key => $role)
													<option value="{{ $key }}">{{ $role }}</option>
												@endforeach
											</select>
										</p>
									</div>
									<div class="col-sm-2 col-md-3">
										<p><a @click="clearRestriction(restriction)" class="btn btn-block btn-danger">{!! icon('close') !!}<span>Clear</span></a></p>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-5 col-md-offset-2">
							<mobile>
								<p>{!! Form::button("Update Field", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
							</mobile>
							<desktop>
								<div class="btn-toolbar">
									<div class="btn-group">
										{!! Form::button("Update Field", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
									</div>
								</div>
							</desktop>
						</div>
					</div>
				</div>
			</div>

			<div id="attributes" class="tab-pane">
				<h3>Field Attributes</h3>

				{!! alert('warning', "Only the following field attributes will be reflected in the Live Preview: class, placeholder, and rows. Any other attributes you add will be reflected in the final field.") !!}

				<div class="form-group">
					<div class="col-md-9 col-lg-8">
						<div class="data-table data-table-striped data-table-bordered">
							<div class="row">
								<div class="col-sm-6 col-md-5"><p><strong>Attribute Name</strong></p></div>
								<div class="col-sm-6 col-md-5"><p><strong>Value</strong></p></div>
								<div class="col-md-2 hidden-xs hidden-sm"></div>
							</div>
							<div class="row" v-for="attr in attributes">
								<div class="col-sm-6 col-md-5">
									<p><input name="attributeNames[]" class="form-control" v-model="attr.name"></p>
								</div>
								<div class="col-sm-6 col-md-5">
									<p><input name="attributeValues[]" class="form-control" v-model="attr.value"></p>
								</div>
								<div class="col-xs-12 col-md-2">
									<p><a @click="removeAttribute(attr)" class="btn btn-block btn-danger">{!! icon('close') !!}<span>Remove</span></a></p>
								</div>
							</div>
						</div>

						<mobile>
							<p><a @click="addAttribute" class="btn btn-block btn-default">{!! icon('add') !!}<span>Add Attribute</span></a></p>
						</mobile>
						<desktop>
							<p><a @click="addAttribute" class="btn btn-default">{!! icon('add') !!}<span>Add Attribute</span></a></p>
						</desktop>
					</div>
				</div>

				<div class="form-group">
					<mobile>
						<p>{!! Form::button("Update Field", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
					</mobile>
					<desktop>
						<div class="btn-toolbar">
							<div class="btn-group">
								{!! Form::button("Update Field", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
							</div>
						</div>
					</desktop>
				</div>
			</div>

			<div id="values" class="tab-pane">
				<h3>Field Values</h3>

				<div v-show="type == 'select'">
					{!! alert('info', "If you want to create an empty first item, you can either create a value in the table below with a blank value or you can specify a placeholder attribute. Both will accomplish the same thing.") !!}
				</div>

				<div class="form-group">
					<div class="col-md-10 col-lg-8">
						<div class="data-table data-table-striped data-table-bordered" id="sortable">
							<div class="row">
								<div class="col-sm-2"></div>
								<div class="col-sm-5 col-md-4"><p><strong>Text</strong></p></div>
								<div class="col-sm-5 col-md-4"><p><strong>Value</strong></p></div>
								<div class="col-md-2 hidden-xs hidden-sm"></div>
							</div>
							<div class="row" v-for="option in options">
								<div class="col-xs-2">
									<p class="text-center"><span class="uk-icon uk-icon-bars sortable-handle"></span></p>
								</div>
								<div class="col-xs-10 col-sm-5 col-md-4">
									<p><input name="optionNames[]" class="form-control" v-model="option.text" placeholder="Text"></p>
								</div>
								<div class="col-xs-12 col-sm-5 col-md-4">
									<p><input name="optionValues[]" class="form-control" v-model="option.value" placeholder="Value"></p>
								</div>
								<div class="col-xs-12 col-md-2">
									<p><a @click="removeOption(option)" class="btn btn-block btn-danger">{!! icon('close') !!}<span>Remove</span></a></p>
								</div>
							</div>
						</div>

						<mobile>
							<p><a @click="addOption" class="btn btn-block btn-default">{!! icon('add') !!}<span>Add Value</span></a></p>
						</mobile>
						<desktop>
							<p><a @click="addOption" class="btn btn-default">{!! icon('add') !!}<span>Add Value</span></a></p>
						</desktop>
					</div>
				</div>

				<div class="form-group">
					<mobile>
						<p>{!! Form::button("Update Field", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
					</mobile>
					<desktop>
						<div class="btn-toolbar">
							<div class="btn-group">
								{!! Form::button("Update Field", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
							</div>
						</div>
					</desktop>
				</div>
			</div>

			<div id="validation" class="tab-pane">
				<h3>Field Validation</h3>

				<p>You can create validation rules that will run on this field when a record is created or updated. You can use as many validation rules as you want, but <strong>all rules must validate</strong> in order for the record to be created/updated. If a rule fails, the user will be directed back to the form with error messages.</p>

				<p>Simply select the condition you want to be true. In some cases, you'll need to provide additional information for the rule.</p>

				<div class="form-group">
					<div class="col-md-10 col-lg-8">
						<div class="data-table data-table-striped data-table-bordered">
							<div class="row">
								<div class="col-sm-6 col-md-5"><p><strong>Must be...</strong></p></div>
								<div class="col-sm-6 col-md-5"><p><strong>Value</strong></p></div>
								<div class="col-md-2 hidden-xs hidden-sm"></div>
							</div>
							<div class="row" v-for="rule in rules">
								<div class="col-sm-6 col-md-5">
									<p>
										<select name="ruleTypes[]" class="form-control" v-model="rule.type" @change="updateRuleType(rule)">
											<option value=""></option>
											<option value="alpha">Alphabetic characters</option>
											<option value="alpha_dash">Alphabetic characters, dashes, or underscores</option>
											<option value="alpha_num">Alpha-numeric characters</option>
											<option value="between">Between two values</option>
											<option value="email">Email address</option>
											<option value="exists">In the database table and column specified</option>
											<option value="in">In the included list of values</option>
											<option value="integer">Integer</option>
											<option value="max">Less than or equal to the value</option>
											<option value="min">Greater than or equal to the value</option>
											<option value="not_in">Not in the included list of values</option>
											<option value="numeric">Numeric</option>
											<option value="required">Required</option>
											<option value="string">String</option>
											<option value="url">URL</option>
										</select>
									</p>
								</div>
								<div class="col-sm-6 col-md-5">
									<p v-show="rule.hasValue"><input name="ruleValues[]" class="form-control" v-model="rule.value"></p>
									
									<p class="help-block" v-show="rule.type == 'between'"><em>min,max</em></p>
									<p class="help-block" v-show="rule.type == 'exists'"><em>table,column</em></p>
									<p class="help-block" v-show="rule.type == 'in'"><em>foo,bar,...</em></p>
									<p class="help-block" v-show="rule.type == 'max'"><em>value</em></p>
									<p class="help-block" v-show="rule.type == 'min'"><em>value</em></p>
									<p class="help-block" v-show="rule.type == 'not_in'"><em>foo,bar,...</em></p>
								</div>
								<div class="col-xs-12 col-md-2">
									<p><a @click="removeRule(rule)" class="btn btn-block btn-danger">{!! icon('close') !!}<span>Remove</span></a></p>
								</div>
							</div>
						</div>

						<mobile>
							<p><a @click="addRule" class="btn btn-block btn-default">{!! icon('add') !!}<span>Add Rule</span></a></p>
						</mobile>
						<desktop>
							<p><a @click="addRule" class="btn btn-default">{!! icon('add') !!}<span>Add Rule</span></a></p>
						</desktop>
					</div>
				</div>

				<div class="form-group">
					<mobile>
						<p>{!! Form::button("Update Field", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
					</mobile>
					<desktop>
						<div class="btn-toolbar">
							<div class="btn-group">
								{!! Form::button("Update Field", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
							</div>
						</div>
					</desktop>
				</div>
			</div>
		</div>

		{!! Form::hidden('form_id', $form->id) !!}
	{!! Form::close() !!}
</div>