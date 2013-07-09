{{ Form::open() }}
	<div class="control-group">
		<div class="controls">
			{{ Form::email('email', null, ['placeholder' => ucwords(lang('email_address'))]) }}
		</div>
	</div>
	
	<div class="control-group">
		<div class="controls">
			{{ Form::password('password', ['placeholder' => lang('Password')]) }}
		</div>
	</div>

	<div class="control-group">
		{{ Form::token() }}
		{{ Form::button(ucwords(lang('action.login')), ['class' => 'btn btn-primary btn-block btn-large', 'type' => 'submit']) }}
	</div>

	<div class="row">
		<div class="col-12 col-sm-6 col-lg-6">
			<p><a href="{{ URL::to('login/reset') }}" class="btn btn-block btn-default">{{ lang('short.forgotPassword') }}</a></p>
		</div>
		<div class="col-12 col-sm-6 col-lg-6">
			<p><a href="{{ URL::to('/') }}" class="btn btn-block btn-default">{{ lang('short.backToSite') }}</a></p>
		</div>
	</div>
{{ Form::close() }}