<form action="{{ route('login') }}" method="POST" role="form">
    @csrf

    <form-field
        label="Email"
        field-id="email"
        error="{{ $errors->first('email') }}"
    >
        <input id="email" type="email" class="field" name="email" value="{{ old('email') }}" data-cy="email" required autofocus>
    </form-field>

    <password-field :allow-showing-password="true" label="Password" name="password"></password-field>

    <div class="flex items-center justify-between mt-8">
        <div>
            <stateful-button type="submit" class="button-primary" data-cy="submit">
                Sign In
            </stateful-button>
        </div>

        @if (Route::has('password.request'))
            <a class="button button-text" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
    </div>
</form>
