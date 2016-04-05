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

{!! Form::model($form, ['route' => ['admin.forms.update', $form->key], 'class' => 'form-horizontal', 'method' => 'put']) !!}
	<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Form Name</label>
		<div class="col-md-5">
			{!! Form::text('name', null, ['class' => 'form-control input-lg', 'v-model' => 'name', 'v-on:change' => 'updateName']) !!}
			{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group{{ ($errors->has('key')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Form Key</label>
		<div class="col-md-3">
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
					<label>{!! Form::radio('status', Status::ACTIVE) !!} {{ ucwords(Status::toString(Status::ACTIVE)) }}</label>
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
			<h3>Form Viewer</h3>

			<p>Form Viewer is an easy way for users to fill out forms that you've created without needing to write any of the code yourself. All entries submitted for a Form Viewer form will be stored in the database and available to administrators for review.</p>
		</div>
	</div>

	<div class="form-group{{ ($errors->has('form_viewer')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Use Form Viewer</label>
		<div class="col-md-5">
			<div>
				<div class="radio">
					<label>{!! Form::radio('form_viewer', (int) true, true) !!} Yes</label>
				</div>
				<div class="radio">
					<label>{!! Form::radio('form_viewer', (int) false) !!} No</label>
				</div>
			</div>
			{!! $errors->first('form_viewer', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-5 col-md-offset-2" v-cloak>
			<mobile>
				<p>{!! Form::button("Update Form", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
			</mobile>
			<desktop>
				<div class="btn-toolbar">
					<div class="btn-group">
						{!! Form::button("Update Form", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
					</div>
				</div>
			</desktop>
		</div>
	</div>
{!! Form::close() !!}