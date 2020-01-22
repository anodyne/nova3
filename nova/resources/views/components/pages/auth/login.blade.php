<form action="{{ route('login') }}" method="POST" role="form">
    @csrf

    <form-field
        label="Email"
        field-id="email"
        error="{{ $errors->first('email') }}"
    >
        <div class="field-group">
            <input id="email" type="email" class="field" name="email" value="{{ old('email') }}" required autofocus>
        </div>
    </form-field>

    <password-field :allow-showing-password="true" label="Password" name="password"></password-field>

    <div class="flex items-center justify-between mt-8">
        <div>
            <stateful-button type="submit" class="button button-primary">
                Sign In
            </stateful-button>
        </div>

        @if (Route::has('password.request'))
            <a class="button-text" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
    </div>
</form>
