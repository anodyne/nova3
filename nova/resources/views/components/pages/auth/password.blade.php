@if (session()->has('password_reset_required'))
	{!! alert('warning', session()->get('password_reset_required'), _m('signin-required-reset')) !!}
@endif

{!! Form::open(['route' => 'password.email']) !!}
	<div class="card">
		<div class="card-block">
			<div class="form-group">
				<label class="sr-only">{{ _m('email-address') }}</label>
				{!! Form::email('email', null, ['class' => 'form-control form-control-lg', 'placeholder' => _m('email-address')]) !!}
			</div>

			<button type="submit" class="btn btn-primary btn-lg btn-block">{!! icon('paper-plane') !!} {{ _m('signin-send-reset-link') }}</button>

			<a href="{{ route('home') }}" class="btn btn-link btn-block" role="button">{{ _m('cancel') }}</a>
		{!! Form::close() !!}
	</div>
</div>