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

<h3>Live Preview</h3>

<div class="well">
	@if ($form->orientation == 'horizontal')
		<div class="form-horizontal">
			<div class="form-group">
				<label class="control-label @{{ labelContainerClass }}" v-show="label != ''">@{{ label }}</label>
				<div class="@{{ fieldContainerClass }}">
					<div v-show="type == 'text'">
						<input type="text" :class="attrClass" :placeholder="attrPlaceholder" :id="attrId">
					</div>
					<div v-show="type == 'textarea'">
						<textarea :class="attrClass" :placeholder="attrPlaceholder" :id="attrId" :rows="attrRows"></textarea>
					</div>
					<div v-show="type == 'select'">
						<select :class="attrClass" :placeholder="attrPlaceholder" :id="attrId">
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
						<input type="text" :class="attrClass" :placeholder="attrPlaceholder" :id="attrId">
					</div>
					<div v-show="type == 'textarea'">
						<textarea :class="attrClass" :placeholder="attrPlaceholder" :id="attrId" :rows="attrRows"></textarea>
					</div>
					<div v-show="type == 'select'">
						<select :class="attrClass" :placeholder="attrPlaceholder" :id="attrId">
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

{!! Form::open(['route' => ['admin.forms.fields.store', $form->key], 'class' => 'form-horizontal']) !!}
	<div class="form-group{{ ($errors->has('type')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Type</label>
		<div class="col-md-4">
			{!! Form::select('type', $types, null, ['class' => 'form-control input-lg', 'placeholder' => "Please choose a field type", 'v-model' => 'type']) !!}
			{!! $errors->first('type', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-10 col-md-offset-2">
			<h3>Placement</h3>
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
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-10 col-md-offset-2">
			<h3>Field Info</h3>
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
		<label class="col-md-2 control-label">Label</label>
		<div class="col-md-4">
			{!! Form::text('label', null, ['class' => 'form-control input-lg', 'v-model' => 'label']) !!}
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
			<h3>Field Attributes</h3>

			{!! alert('warning', "Only the following field attributes will be reflected in the Live Preview: ID, class, placeholder, and rows. Any other attributes you add will be reflected in the final field.") !!}
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-8 col-md-offset-2">
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
						<p><input name="attributeName[]" class="form-control" v-model="attr.name"></p>
					</div>
					<div class="col-md-5">
						<p><input name="attributeValue[]" class="form-control" v-model="attr.value"></p>
					</div>
					<div class="col-md-2">
						<p><a @click="removeAttribute(attr)" class="btn btn-block btn-danger">Remove</a></p>
					</div>
				</div>
			</div>

			<p><a @click="addAttribute" class="btn btn-default">Add Attribute</a></p>
		</div>
	</div>

	<div v-if="type == 'select' || type == 'radio'">
		<div class="form-group">
			<div class="col-md-10 col-md-offset-2">
				<h3>Field Values</h3>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-8 col-md-offset-2">
				<div class="data-table data-table-striped data-table-bordered">
					<div class="row">
						<div class="col-md-5"><p><strong>Text</strong></p></div>
						<div class="col-md-5"><p><strong>Value</strong></p></div>
						<div class="col-md-2"></div>
					</div>
					<div class="row" v-for="option in options">
						<div class="col-md-5">
							<p><input name="optionNames[]" class="form-control" v-model="option.text"></p>
						</div>
						<div class="col-md-5">
							<p><input name="optionValues[]" class="form-control" v-model="option.value"></p>
						</div>
						<div class="col-md-2">
							<p><a @click="removeOption(option)" class="btn btn-block btn-danger">Remove</a></p>
						</div>
					</div>
				</div>

				<p><a @click="addOption" class="btn btn-default">Add Value</a></p>
			</div>
		</div>
	</div>

	{!! Form::hidden('form_id', $form->id) !!}

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
{!! Form::close() !!}