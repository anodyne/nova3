<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/user') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>
</div>

{{ Form::model($user, ['url' => 'admin/user']) }}
	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="form-group">
				<label class="control-label">{{ lang('Name') }}</label>
				{{ Form::text('name', null, ['class' => 'form-control']) }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="form-group">
				<label class="control-label">{{ ucwords(lang('email_address')) }}</label>
				{{ Form::email('email', null, ['class' => 'form-control']) }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="form-group">
				<label class="control-label">{{ lang('Password') }}</label>
				{{ Form::password('password', ['class' => 'form-control']) }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="form-group">
				<label class="control-label">{{ langConcat('Action.confirm Password') }}</label>
				{{ Form::password('password_confirm', ['class' => 'form-control']) }}
			</div>
		</div>
	</div>

	@if (Character::npc()->count() > 0)
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
	@endif
{{ Form::close() }}