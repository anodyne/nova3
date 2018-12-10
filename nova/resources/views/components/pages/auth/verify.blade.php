<div class="text-center text-4xl font-extrabold mb-1 text-primary-dark">{{ _m('auth-verify-email') }}</div>
<div class="text-center text-grey-dark text-sm mb-12">Free access to our dashboard</div>

@if (session('resent'))
	<div class="alert alert-success" role="alert">
		{{ _m('auth-verify-email-resent') }}
	</div>
@endif

{{ _m('auth-verify-email-before') }}
{{ _m('auth-verify-email-request') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.