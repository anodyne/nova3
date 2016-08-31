{!! Form::open(['route' => 'admin.users.store', 'class' => 'form-horizontal']) !!}
	<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Name</label>
		<div class="col-md-5">
			{!! Form::text('name', null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label">Nickname</label>
		<div class="col-md-5">
			{!! Form::text('nickname', null, ['class' => 'form-control input-lg']) !!}
			<p class="help-block">If a nickname is entered, Nova will display it instead of a real name</p>
		</div>
	</div>

	<div class="form-group{{ ($errors->has('email')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Email Address</label>
		<div class="col-md-5">
			{!! Form::email('email', null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group{{ ($errors->has('password')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Password</label>
		<div class="col-md-4">
			{!! Form::text('password', null, ['class' => 'form-control input-lg', 'v-model' => 'password']) !!}
			{!! $errors->first('password', '<p class="help-block">:message</p>') !!}
		</div>
		<div class="col-md-3">
			<p><a href="#" class="btn btn-link btn-lg" @click.prevent="generatePassword">Generate a Password</a></p>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label">Confirm Password</label>
		<div class="col-md-4">
			{!! Form::text('password_confirmation', null, ['class' => 'form-control input-lg', 'v-model' => 'passwordConfirmation']) !!}
			{!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group{{ ($errors->has('role')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Access Role</label>
		<div class="col-md-6">
			{!! partial('access-picker', ['type' => '', 'selectedItems' => '[]']) !!}
			{!! $errors->first('role', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-5 col-md-offset-2" v-cloak>
			<mobile>
				<p>{!! Form::button("Add User", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
				<p><a href="{{ route('admin.users') }}" class="btn btn-link-default btn-lg">Cancel</a></p>
			</mobile>
			<desktop>
				<div class="btn-toolbar">
					<div class="btn-group">
						{!! Form::button("Add User", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
					</div>
					<div class="btn-group">
						<a href="{{ route('admin.users') }}" class="btn btn-link-default btn-lg">Cancel</a>
					</div>
				</div>
			</desktop>
		</div>
	</div>
{!! Form::close() !!}