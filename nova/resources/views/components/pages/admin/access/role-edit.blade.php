<div v-cloak>
	<phone-tablet>
		<p><a href="{{ route('admin.access.roles') }}" class="btn btn-default btn-lg btn-block">Back to Roles</a></p>
	</phone-tablet>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.access.roles') }}" class="btn btn-default">Back to Roles</a>
			</div>
		</div>
	</desktop>
</div>

{!! Form::model($role, ['route' => ['admin.access.roles.update', $role->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
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
		<label class="col-md-2 control-label">Permissions</label>
		<div class="col-md-10">
			@foreach ($permissions as $component => $permission)
				<fieldset>
					<legend>{{ $component }}</legend>

					<div class="row">
						@foreach ($permission as $p)
							<div class="col-md-4">
								<label class="checkbox-inline">
									{!! Form::checkbox('permissions[]', $p->id) !!}
									{!! $p->present()->displayName !!}
								</label>
							</div>
						@endforeach
					</div>
				</fieldset>
			@endforeach
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-5 col-md-offset-2" v-cloak>
			<phone-tablet>
				<p>{!! Form::button("Update Role", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
			</phone-tablet>
			<desktop>
				<div class="btn-toolbar">
					<div class="btn-group">
						{!! Form::button("Update Role", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
					</div>
				</div>
			</desktop>
		</div>
	</div>
{!! Form::close() !!}