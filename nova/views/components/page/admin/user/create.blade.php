<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/user') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>
</div>

{{ Form::model($user, ['url' => 'admin/user/create']) }}
	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
				<label class="control-label">{{ lang('Name') }}</label>
				{{ Form::text('name', null, ['class' => 'form-control input-with-feedback']) }}
				{{ $errors->first('name', '<p class="help-block">:message</p>') }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="form-group{{ ($errors->has('email')) ? ' has-error' : '' }}">
				<label class="control-label">{{ ucwords(lang('email_address')) }}</label>
				{{ Form::email('email', null, ['class' => 'form-control input-with-feedback']) }}
				{{ $errors->first('email', '<p class="help-block">:message</p>') }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="form-group{{ ($errors->has('password')) ? ' has-error' : '' }}">
				<label class="control-label">{{ lang('Password') }}</label>
				{{ Form::password('password', ['class' => 'form-control input-with-feedback']) }}
				{{ $errors->first('password', '<p class="help-block">:message</p>') }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="form-group{{ ($errors->has('password_confirm')) ? ' has-error' : '' }}">
				<label class="control-label">{{ langConcat('Action.confirm Password') }}</label>
				{{ Form::password('password_confirm', ['class' => 'form-control input-with-feedback']) }}
				{{ $errors->first('password_confirm', '<p class="help-block">:message</p>') }}
			</div>
		</div>
	</div>

	@if (CharacterModel::npc()->count() > 0)
		<div class="row">
			<div class="col-sm-8 col-lg-6">
				<label class="control-label">{{ langConcat('Primary Character') }}</label>
				{{ Form::characters('character_id', null, ['class' => 'form-control'], Status::UNASSIGNED) }}
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="help-block">{{ lang('short.admin.users.choosePrimaryCharacter') }}</p>
			</div>
		</div>
	@else
		{{ Form::hidden('character_id', 0) }}
	@endif

	<div class="row">
		<div class="col-lg-12">
			{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
		</div>
	</div>
{{ Form::close() }}