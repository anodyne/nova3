<div v-cloak>
	<phone-tablet>
		<p><a href="{{ route('admin.forms.fields', [$form->key]) }}" class="btn btn-default btn-lg btn-block">Back to Form Fields</a></p>
	</phone-tablet>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.forms.fields', [$form->key]) }}" class="btn btn-default">Back to Form Fields</a>
			</div>
		</div>
	</desktop>
</div>

<div v-show="hasType">
	<h3>Live Preview</h3>

	<div class="well">
		@if ($form->orientation == 'horizontal')
			<div class="form-horizontal">
				<div class="form-group">
					<label class="control-label @{{ labelContainerClass }}" v-show="label != ''">@{{ label }}</label>
					<div class="@{{ fieldContainerClass }}">
						<div v-show="type == 'text'">
							<input type="text" :class="attrClass" :placeholder="attrPlaceholder">
						</div>
						<div v-show="type == 'textarea'">
							<textarea :class="attrClass" :placeholder="attrPlaceholder" :rows="attrRows"></textarea>
						</div>
						<div v-show="type == 'select'">
							<select :class="attrClass" :placeholder="attrPlaceholder">
								<option v-for="option in options" :value="option.value">@{{ option.text }}</option>
							</select>
						</div>
						<div v-show="type == 'radio'">
							<div class="radio" v-for="option in options">
								<label>
									<input type="radio" :value="option.value"> @{{ option.text }}
								</label>
							</div>
						</div>

						<p class="help-block" v-show="help != ''">@{{ help }}</p>
					</div>
				</div>
			</div>
		@else
			<div class="row">
				<div class="@{{ fieldContainerClass }}">
					<div class="form-group">
						<label class="control-label" v-show="label != ''">@{{ label }}</label>

						<div v-show="type == 'text'">
							<input type="text" :class="attrClass" :placeholder="attrPlaceholder">
						</div>
						<div v-show="type == 'textarea'">
							<textarea :class="attrClass" :placeholder="attrPlaceholder" :rows="attrRows"></textarea>
						</div>
						<div v-show="type == 'select'">
							<select :class="attrClass" :placeholder="attrPlaceholder">
								<option v-for="option in options" :value="option.value">@{{ option.text }}</option>
							</select>
						</div>
						<div v-show="type == 'radio'">
							<div class="radio" v-for="option in options">
								<label>
									<input type="radio" :value="option.value"> @{{ option.text }}
								</label>
							</div>
						</div>

						<p class="help-block" v-show="help != ''">@{{ help }}</p>
					</div>
				</div>
			</div>
		@endif
	</div>
</div>

<ul class="nav nav-pills">
	<li class="active"><a href="#basic" data-toggle="pill">Basic Info</a></li>
	<li v-show="hasType"><a href="#attributes" data-toggle="pill">Attributes</a></li>
	<li v-show="hasType"><a href="#validation" data-toggle="pill">Validation</a></li>
	<li v-show="hasValues"><a href="#values" data-toggle="pill">Values</a></li>
</ul>

{!! Form::open(['route' => ['admin.forms.fields.store', $form->key], 'class' => 'form-horizontal']) !!}
	<div class="tab-content">
		<div id="basic" class="tab-pane active">
			<div class="form-group{{ ($errors->has('type')) ? ' has-error' : '' }}">
				<label class="col-md-2 control-label">Type</label>
				<div class="col-md-4">
					{!! Form::select('type', $types, null, ['class' => 'form-control input-lg', 'placeholder' => "Please choose a field type", 'v-model' => 'type']) !!}
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
						{!! Form::select('field_container_class_select', $sizes, null, ['class' => 'form-control input-lg', 'v-model' => 'fieldContainerClassSelect']) !!}
					</div>
					<div class="col-md-3" v-show="fieldContainerClassSelect == 'Custom'">
						{!! Form::text('field_container_class', null, ['class' => 'form-control input-lg', 'v-model' => 'fieldContainerClass']) !!}
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">Label Size</label>
					<div class="col-md-3">
						{!! Form::select('label_container_class_select', $sizes, null, ['class' => 'form-control input-lg', 'v-model' => 'labelContainerClassSelect']) !!}
					</div>
					<div class="col-md-3" v-show="labelContainerClassSelect == 'Custom'">
						{!! Form::text('label_container_class', null, ['class' => 'form-control input-lg', 'v-model' => 'labelContainerClass']) !!}
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">Help Text</label>
					<div class="col-md-6">
						{!! Form::textarea('help', null, ['class' => 'form-control input-lg', 'rows' => 3, 'v-model' => 'help']) !!}
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
						{!! Form::select('tab_id', $tabs, null, ['class' => 'form-control input-lg']) !!}
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">Form Section</label>
					<div class="col-md-4">
						{!! Form::select('section_id', $sections, null, ['class' => 'form-control input-lg']) !!}
						<p class="help-block">If you specify a section, you do not need to specify a tab.</p>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-10 col-md-offset-2">
						<h3>Restrictions</h3>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-6 col-md-offset-2">
						<div class="data-table data-table-striped data-table-bordered">
							<div class="row">
								<div class="col-md-3"><p><strong>Type</strong></p></div>
								<div class="col-md-6"><p><strong>Value</strong></p></div>
								<div class="col-md-3"></div>
							</div>
							<div class="row" v-for="restriction in restrictions">
								<div class="col-md-3">
									<p>@{{ restriction.type | capitalize }}</p>
								</div>
								<div class="col-md-6">
									<p>{!! Form::select('restrictionValues[@{{ restriction.type }}]', $accessRoles, null, ['class' => 'form-control', 'v-model' => 'restriction.value', 'placeholder' => "No restriction"]) !!}</p>
								</div>
								<div class="col-md-3">
									<p><a @click="clearRestriction(restriction)" class="btn btn-block btn-danger">Clear</a></p>
								</div>
							</div>
						</div>

						{!! Form::hidden('val_rules', false, ['v-model' => 'validationRules']) !!}
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-5 col-md-offset-2" v-cloak>
						<phone-tablet>
							<p>{!! Form::button("Add Field", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
						</phone-tablet>
						<desktop>
							<div class="btn-toolbar">
								<div class="btn-group">
									{!! Form::button("Add Field", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
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
				<div class="col-md-8">
					<div class="data-table data-table-striped data-table-bordered">
						<div class="row">
							<div class="col-md-5">
								<p><strong>Attribute Name</strong></p>
							</div>
							<div class="col-md-5">
								<p><strong>Value</strong></p>
							</div>
							<div class="col-md-2"></div>
						</div>
						<div class="row" v-for="attr in attributes">
							<div class="col-md-5">
								<p><input name="attributeNames[]" class="form-control" v-model="attr.name"></p>
							</div>
							<div class="col-md-5">
								<p><input name="attributeValues[]" class="form-control" v-model="attr.value"></p>
							</div>
							<div class="col-md-2">
								<p><a @click="removeAttribute(attr)" class="btn btn-block btn-danger">Remove</a></p>
							</div>
						</div>
					</div>

					<p><a @click="addAttribute" class="btn btn-default">Add Attribute</a></p>
				</div>
			</div>

			<div class="form-group">
				<div v-cloak>
					<phone-tablet>
						<p>{!! Form::button("Add Field", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
					</phone-tablet>
					<desktop>
						<div class="btn-toolbar">
							<div class="btn-group">
								{!! Form::button("Add Field", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
							</div>
						</div>
					</desktop>
				</div>
			</div>
		</div>

		<div id="values" class="tab-pane">
			<h3>Field Values</h3>

			<div v-show="type == 'select'">
				{!! alert('info', "If you want to create an empty first item, you can either create a value in the table below with a blank value or you can specify a placeholder attribute. Both will accomplish the same thing.") !!}
			</div>

			<div class="form-group">
				<div class="col-md-8">
					<div class="data-table data-table-striped data-table-bordered" id="sortable">
						<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-5"><p><strong>Text</strong></p></div>
							<div class="col-md-4"><p><strong>Value</strong></p></div>
							<div class="col-md-2"></div>
						</div>
						<div class="row" v-for="option in options">
							<div class="col-xs-1">
								<p class="text-center"><span class="uk-icon uk-icon-bars sortable-handle"></span></p>
							</div>
							<div class="col-xs-11 col-md-5">
								<p><input name="optionNames[]" class="form-control" v-model="option.text"></p>
							</div>
							<div class="col-xs-12 col-md-4">
								<p><input name="optionValues[]" class="form-control" v-model="option.value"></p>
							</div>
							<div class="col-xs-12 col-md-2">
								<p><a @click="removeOption(option)" class="btn btn-block btn-danger">Remove</a></p>
							</div>
						</div>
					</div>

					<p><a @click="addOption" class="btn btn-default">Add Value</a></p>
				</div>
			</div>

			<div class="form-group">
				<div v-cloak>
					<phone-tablet>
						<p>{!! Form::button("Add Field", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
					</phone-tablet>
					<desktop>
						<div class="btn-toolbar">
							<div class="btn-group">
								{!! Form::button("Add Field", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
							</div>
						</div>
					</desktop>
				</div>
			</div>
		</div>

		<div id="validation" class="tab-pane">
			<h3>Field Validation</h3>

			<p>You can create validation rules that will run on this field when a record is created or updated. You can use as many validation rules as you want, but <strong>all rules must validate</strong> in order for the record to be created/updated. If a rule fails, the user will be directed back to the form with error messages.</p>

			<p>Simply select the condition you want to be true. In some cases, you'll need to provide additional information for the rule.</p>

			<div class="form-group">
				<div class="col-md-8">
					<div class="data-table data-table-striped data-table-bordered">
						<div class="row">
							<div class="col-md-6"><p><strong>Must be...</strong></p></div>
							<div class="col-md-4"><p><strong>Value</strong></p></div>
							<div class="col-md-2"></div>
						</div>
						<div class="row" v-for="rule in rules">
							<div class="col-md-6">
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
							<div class="col-md-4">
								<p v-show="rule.hasValue"><input name="ruleValues[]" class="form-control" v-model="rule.value" @change="updateRuleValue(rule)"></p>
								
								<p class="help-block" v-show="rule.type == 'between'"><em>min,max</em></p>
								<p class="help-block" v-show="rule.type == 'exists'"><em>table,column</em></p>
								<p class="help-block" v-show="rule.type == 'in'"><em>foo,bar,...</em></p>
								<p class="help-block" v-show="rule.type == 'max'"><em>value</em></p>
								<p class="help-block" v-show="rule.type == 'min'"><em>vakye</em></p>
								<p class="help-block" v-show="rule.type == 'not_in'"><em>foo,bar,...</em></p>
							</div>
							<div class="col-md-2">
								<p><a @click="removeRule(rule)" class="btn btn-block btn-danger">Remove</a></p>
							</div>
						</div>
					</div>

					<p><a @click="addRule" class="btn btn-default">Add Rule</a></p>

					{!! Form::hidden('val_rules', false, ['v-model' => 'validationRules']) !!}
				</div>
			</div>

			<div class="form-group">
				<div v-cloak>
					<phone-tablet>
						<p>{!! Form::button("Add Field", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
					</phone-tablet>
					<desktop>
						<div class="btn-toolbar">
							<div class="btn-group">
								{!! Form::button("Add Field", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
							</div>
						</div>
					</desktop>
				</div>
			</div>
		</div>
	</div>

	{!! Form::hidden('form_id', $form->id) !!}
{!! Form::close() !!}