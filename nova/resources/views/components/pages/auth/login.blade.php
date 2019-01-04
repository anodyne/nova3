<h1 class="mb-8 font-extrabold text-blue-dark text-5xl">Sign In</h1>

<form action="{{ route('login') }}" method="POST">
    @csrf

    <div class="field-wrapper">
        <div class="field-label">
            <label for="email">{{ __('Email Address') }}</label>
        </div>

        <div class="field-group">
            <input id="email" type="email" class="field" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        @if ($errors->has('email'))
            <div class="field-error" role="alert">{{ $errors->first('email') }}</div>
        @endif
    </div>

    <password-field :allow-showing-password="true" label="Password" name="password"></password-field>

    <div class="flex items-center justify-between">
        <div>
            <button type="submit" class="button button-primary button-large">
                {{ __('Sign In') }}
            </button>
        </div>

        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
    </div>
</form>