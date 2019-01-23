<h1 class="mb-8 font-extrabold text-primary-600 text-5xl">Reset Password</h1>

<form action="{{ route('password.update') }}" method="POST">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="field-wrapper">
        <div class="field-label">
            <label for="email">{{ __('E-Mail Address') }}</label>
        </div>

        <div class="field-group">
            <input id="email" type="email" class="field" name="email" value="{{ $email ?? old('email') }}" required autofocus>
        </div>

        @if ($errors->has('email'))
            <div class="field-error" role="alert">{{ $errors->first('email') }}</div>
        @endif
    </div>

    <div class="field-wrapper">
        <div class="field-label">
            <label for="password">{{ __('Password') }}</label>
        </div>

        <div class="field-group">
            <input id="password" type="password" class="field" name="password" required>
        </div>

        @if ($errors->has('password'))
            <div class="field-error" role="alert">{{ $errors->first('password') }}</div>
        @endif
    </div>

    <div class="field-wrapper">
        <div class="field-label">
            <label for="password-confirm">{{ __('Confirm Password') }}</label>
        </div>

        <div class="field-group">
            <input id="password-confirm" type="password" class="field" name="password_confirmation" required>
        </div>
    </div>

    <button type="submit" class="button button-primary button-large">
        {{ __('Reset Password') }}
    </button>
</form>