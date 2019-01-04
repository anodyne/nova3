<h1 class="mb-8 font-extrabold text-blue-dark text-5xl">Reset Password</h1>

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

<form action="{{ route('password.email') }}" method="POST">
    @csrf

    <div class="field-wrapper">
        <div class="field-label">
            <label for="email">{{ __('E-Mail Address') }}</label>
        </div>

        <div class="field-group">
            <input id="email" type="email" class="field" name="email" value="{{ old('email') }}" required>
        </div>

        @if ($errors->has('email'))
            <div class="form-error" role="alert">{{ $errors->first('email') }}</div>
        @endif
    </div>

    <button type="submit" class="button button-primary button-large">
        {{ __('Send Password Reset Link') }}
    </button>
</form>