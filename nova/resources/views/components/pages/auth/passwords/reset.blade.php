<form action="{{ route('password.update') }}" method="POST">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <form-field label="Email" error="{{ $errors->first('email') }}">
        <div class="field-group">
            <input id="email" type="email" class="field" name="email" value="{{ $email ?? old('email') }}" data-cy="email" required autofocus>
        </div>
    </form-field>

    <form-field label="Password" error="{{ $errors->first('password') }}">
        <div class="field-group">
            <input id="password" type="password" class="field" name="password" data-cy="password" required>
        </div>
    </form-field>

    <form-field label="Confirm Password" error="{{ $errors->first('password-confirm') }}">
        <div class="field-group">
            <input id="password-confirm" type="password" class="field" name="password_confirmation" data-cy="password-confirm" required>
        </div>
    </form-field>

    <button type="submit" class="button button-primary mt-8" data-cy="submit">
        {{ __('Reset Password') }}
    </button>
</form>