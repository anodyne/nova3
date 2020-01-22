@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

@if (session('message'))
    <div class="alert alert-warning" role="alert">
        {{ session('message') }}
    </div>
@endif

<p class="text-sm text-gray-600 mb-4">If you can't remember your password, please provide your email address and we will send you a link which you may use to change your password.</p>

<form action="{{ route('password.email') }}" method="POST">
    @csrf

    <div class="field-wrapper">
        <div class="field-label">
            <label for="email">{{ __('Email') }}</label>
        </div>

        <div class="field-group">
            <input id="email" type="email" class="field" name="email" value="{{ old('email') }}" required>
        </div>

        @if ($errors->has('email'))
            <div class="form-error" role="alert">{{ $errors->first('email') }}</div>
        @endif
    </div>

    <button type="submit" class="button button-primary">
        {{ __('Send Reset Link') }}
    </button>
</form>