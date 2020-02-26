@if (session('status'))
    <div class="rounded font-semibold bg-sucess-200 border-2 border-success-300 text-success-700 mb-6" role="alert">
        {{ session('status') }}
    </div>
@endif

@if (session('message'))
    <div class="alert alert-warning" role="alert">
        {{ session('message') }}
    </div>
@endif

<p class="text-sm text-gray-600 mb-6">If you can't remember your password, please provide your email address and we will send you a link which you may use to change your password.</p>

<form action="{{ route('password.email') }}" method="POST">
    @csrf

    <form-field label="Email" error="{{ $errors->first('email') }}">
        <div class="field-group">
            <input id="email" type="email" class="field" name="email" value="{{ old('email') }}" data-cy="email" required>
        </div>
    </form-field>

    <button type="submit" class="button button-primary mt-8" data-cy="submit">
        {{ __('Send Reset Link') }}
    </button>
</form>