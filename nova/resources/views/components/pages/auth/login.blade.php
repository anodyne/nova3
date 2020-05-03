<form action="{{ route('login') }}" method="POST" role="form">
    @csrf

    <x-form.field label="Email" field-id="email" :error="$errors->first('email')">
        <input
        id="email"
        type="email"
        class="field"
        name="email"
        value="{{ old('email') }}"
        data-cy="email"
        required
        autofocus>
    </x-form.field>

    <livewire:password-field label="Password" field-id="password" field-name="password"></livewire:password-field>

    <div class="mt-8 flex items-center justify-between">
        <div class="flex items-center">
            <input
                id="remember"
                type="checkbox"
                name="remember"
                class="form-checkbox h-4 w-4 text-blue-600 transition duration-150 ease-in-out">
            <label for="remember" class="ml-2 block text-sm leading-5 text-gray-900">
                Remember me
            </label>
        </div>

        <div class="text-sm leading-5">
            <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                Forgot your password?
            </a>
        </div>
    </div>

    <div class="mt-8">
        <button type="submit" class="button button-primary w-full justify-center">
            Sign in
        </button>
    </div>
</form>