<h1 class="mb-8 font-extrabold text-blue-600 text-5xl">Sign In</h1>

<form action="{{ route('login') }}" method="POST" role="form">
    @csrf

    <form-field
        label="Email Address"
        field-id="email"
        error="{{ $errors->first('email') }}"
    >
        <div class="field-group">
            <input id="email" type="email" class="field" name="email" value="{{ old('email') }}" required autofocus>
        </div>
    </form-field>

    <password-field :allow-showing-password="true" label="Password" name="password"></password-field>

    <div class="flex items-center justify-between">
        <div>
            <button type="submit" class="button is-primary is-large">
                {{ __('Sign In') }}
            </button>
        </div>

        @if (Route::has('password.request'))
            <a class="button is-text" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
    </div>
</form>
