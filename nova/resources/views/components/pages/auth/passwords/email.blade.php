<h1 class="header">Reset Password</h1>

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

<form action="{{ route('password.email') }}" method="POST" role="form">
    @csrf

    <form-field field-id="email" label="Email Address">
        <div class="field-group">
            <input id="email" type="email" class="field" name="email" value="{{ old('email') }}" required>
        </div>
    </form-field>

    <div class="controls">
        <button type="submit" class="button button-primary button-large">
            Send Password Reset Link
        </button>
    </div>
</form>