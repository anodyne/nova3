{{ Form::open() }}
	<div class="form-group">
		{{ Form::email('email', null, ['placeholder' => ucwords(lang('email_address')), 'class' => 'form-control input-lg']) }}
	</div>
	
	<div class="form-group">
		<div class="controls">
			{{ Form::password('password', ['placeholder' => lang('Password'), 'class' => 'form-control input-lg']) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::token() }}
		{{ Form::button(lang('Action.login'), ['class' => 'btn btn-primary btn-block btn-lg', 'type' => 'submit']) }}
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-lg-12">
			<p><a href="{{ URL::to('login/reset') }}" class="btn btn-block btn-link">{{ lang('short.forgotPassword') }}</a></p>
		</div>
		<div class="col-xs-12 col-sm-12 col-lg-12">
			<p><a href="{{ URL::to('/') }}" class="btn btn-block btn-link">{{ lang('short.backToSite') }}</a></p>
		</div>
	</div>
{{ Form::close() }}