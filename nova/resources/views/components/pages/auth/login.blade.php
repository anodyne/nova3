<div class="card">
	<div class="card-block">
		{!! Form::open(['route' => 'login.login']) !!}
			<div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }}">
				<label class="sr-only">{{ _m('email-address') }}</label>
				{!! Form::email('email', null, ['class' => 'form-control form-control-danger form-control-lg', 'placeholder' => _m('email-address')]) !!}
				{!! $errors->first('email', '<p class="help-block">:message</p>') !!}
			</div>

			<div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
				<label class="sr-only">{{ _m('password') }}</label>
				{!! Form::password('password', ['class' => 'form-control form-control-danger form-control-lg', 'placeholder' => _m('password')]) !!}
				{!! $errors->first('password', '<p class="help-block">:message</p>') !!}
			</div>

			<button type="submit" class="btn btn-primary btn-lg btn-block">{!! icon('sign-in') !!} {{ _m('sign-in') }}</button>
		{!! Form::close() !!}
	</div>

	<div class="card-footer">
		<div class="row">
			<div class="col-md-6">
				<a href="{{ route('password.email.show') }}" class="btn btn-link btn-block">{{ _m('forgot-password') }}</a>
			</div>
			<div class="col-md-6">
				<a href="{{ route('home') }}" class="btn btn-link btn-block">{{ _m('back-home') }}</a>
			</div>
		</div>
	</div>
</div>