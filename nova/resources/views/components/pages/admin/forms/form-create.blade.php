<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.forms') }}" class="btn btn-default btn-lg btn-block">Back to Forms</a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.forms') }}" class="btn btn-default">Back to Forms</a>
			</div>
		</div>
	</desktop>
</div>

{!! Form::open(['route' => 'admin.forms.store', 'class' => 'form-horizontal']) !!}
	<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Form Name</label>
		<div class="col-md-5">
			{!! Form::text('name', null, ['class' => 'form-control input-lg', 'v-model' => 'name', 'v-on:change' => 'updateName']) !!}
			{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group{{ ($errors->has('key')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Form Key</label>
		<div class="col-md-5">
			{!! Form::text('key', null, ['class' => 'form-control input-lg', 'v-model' => 'key', 'v-on:change' => 'updateKey']) !!}
			{!! $errors->first('key', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group{{ ($errors->has('orientation')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Orientation</label>
		<div class="col-md-5">
			<div>
				<div class="radio">
					<label>{!! Form::radio('orientation', 'vertical') !!} Vertical</label>
				</div>
				<div class="radio">
					<label>{!! Form::radio('orientation', 'horizontal') !!} Horizontal</label>
				</div>
			</div>
			{!! $errors->first('orientation', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group{{ ($errors->has('status')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Status</label>
		<div class="col-md-5">
			<div>
				<div class="radio">
					<label>{!! Form::radio('status', Status::ACTIVE, true) !!} {{ ucwords(Status::toString(Status::ACTIVE)) }}</label>
				</div>
				<div class="radio">
					<label>{!! Form::radio('status', Status::INACTIVE) !!} {{ ucwords(Status::toString(Status::INACTIVE)) }}</label>
				</div>
			</div>
			{!! $errors->first('status', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-10 col-md-offset-2">
			<h3>Form Center</h3>

			<p>Form Center is an easy way for users to fill out forms that you've created without needing to write any of the code yourself. All entries submitted for a Form Center form will be stored in the database and available to administrators for review.</p>
		</div>
	</div>

	<div class="form-group{{ ($errors->has('use_form_center')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Use Form Center</label>
		<div class="col-md-5">
			<div>
				<div class="radio-inline">
					<label>{!! Form::radio('use_form_center', (int) true, true, ['v-model' => 'useFormCenter']) !!} Yes</label>
				</div>
				<div class="radio-inline">
					<label>{!! Form::radio('use_form_center', (int) false, false, ['v-model' => 'useFormCenter']) !!} No</label>
				</div>
			</div>
			{!! $errors->first('use_form_center', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div v-if="useFormCenter == true">
		<div class="form-group{{ ($errors->has('allow_multiple_submissions')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Allow Multiple Submissions</label>
			<div class="col-md-5">
				<div>
					<div class="radio-inline">
						<label>{!! Form::radio('allow_multiple_submissions', (int) true, true) !!} Yes</label>
					</div>
					<div class="radio-inline">
						<label>{!! Form::radio('allow_multiple_submissions', (int) false) !!} No</label>
					</div>
				</div>
				<p class="help-block">Do you want users to be able to submit this form multiple times?</p>
				{!! $errors->first('allow_multiple_submissions', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Restrictions</label>
			<div class="col-md-8 col-lg-6">
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
							<p>{!! Form::select('restrictionValues[@{{ restriction.type }}]', $accessRoles, null, ['class' => 'form-control', 'v-model' => 'restriction.value', 'placeholder' => "No restriction"]) !!}</p>
						</div>
						<div class="col-sm-2 col-md-3">
							<p><a @click="clearRestriction(restriction)" class="btn btn-block btn-danger">Clear</a></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-5 col-md-offset-2" v-cloak>
			<mobile>
				<p>{!! Form::button("Add Form", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
			</mobile>
			<desktop>
				<div class="btn-toolbar">
					<div class="btn-group">
						{!! Form::button("Add Form", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
					</div>
				</div>
			</desktop>
		</div>
	</div>
{!! Form::close() !!}