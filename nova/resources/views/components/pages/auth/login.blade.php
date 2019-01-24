<h1 class="header">Sign In</h1>

<form action="{{ route('login') }}" method="POST">
    @csrf

    <form-field
        label="Email Address"
        field-id="email"
        name="email"
    >
        <div class="field-group">
            <input id="email" type="email" class="field" name="email" value="{{ old('email') }}" required autofocus>
        </div>
    </form-field>

    <password-field
        :allow-showing-password="true"
        label="Password"
        name="password"
    ></password-field>

    <div class="controls">
        <button type="submit" class="button button-primary button-large">
            Sign In
        </button>

        @if (Route::has('password.request'))
            <a class="button button-text" href="{{ route('password.request') }}">
                Forgot Your Password?
            </a>
        @endif
    </div>
</form>