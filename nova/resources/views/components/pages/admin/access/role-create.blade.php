<div class="visible-xs visible-sm">
	<p><a href="{{ route('admin.access.roles') }}" class="btn btn-default btn-lg btn-block">Back to Roles</a></p>
</div>
<div class="visible-md visible-lg">
	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ route('admin.access.roles') }}" class="btn btn-default">Back to Roles</a>
		</div>
	</div>
</div>

{!! Form::open(['route' => 'admin.access.roles.store', 'class' => 'form-horizontal']) !!}
	<div class="form-group{{ ($errors->has('display_name')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Name</label>
		<div class="col-md-5">
			{!! Form::text('display_name', null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('display_name', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Key</label>
		<div class="col-md-3">
			{!! Form::text('name', null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-5 col-md-offset-2">
			<p class="help-block">Role keys are a unique name for the role mainly used for looking up role information quickly. This should not be confused with the name that is a human-readable form of the key.</p>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label">Description</label>
		<div class="col-md-6">
			{!! Form::textarea('description', null, ['class' => 'form-control input-lg', 'rows' => 4]) !!}
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-5 col-md-offset-2">
			<div class="visible-xs visible-sm">
				<p>{!! Form::button("Add Role", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
			</div>
			<div class="visible-md visible-lg">
				<div class="btn-toolbar">
					<div class="btn-group">
						{!! Form::button("Add Role", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
{!! Form::close() !!}