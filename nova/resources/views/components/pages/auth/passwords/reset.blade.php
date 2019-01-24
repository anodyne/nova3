<h1 class="header">Reset Password</h1>

<form action="{{ route('password.update') }}" method="POST" role="form">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <form-field name="email" field-id="email" label="Email Address">
        <div class="field-group">
            <input id="email" type="email" class="field" name="email" value="{{ $email ?? old('email') }}" required autofocus>
        </div>
    </form-field>

    <form-field name="password" field-id="password" label="Password">
        <div class="field-group">
            <input id="password" type="password" class="field" name="password" required>
        </div>
    </form-field>

    <form-field name="password_confirmation" field-id="password-confirm" label="Confirm Password">
        <div class="field-group">
            <input id="password-confirm" type="password" class="field" name="password_confirmation" required>
        </div>
    </form-field>

    <div class="controls">
        <button type="submit" class="button button-primary button-large">
            Reset Password
        </button>
    </div>
</form>