@extends($__novaTemplate)

@section('page-header', 'Sign in to your account')

@section('content')
    <x-form :action="route('login')" :divide="false">
        <x-input.group label="Email" for="email" :error="$errors->first('email')">
            <x-input.email id="email" name="email" :value="old('email')" data-cy="email" required autofocus />
        </x-input.group>

        <x-input.group label="Password" for="password">
            <x-input.password id="password" name="password" data-cy="password" required />
        </x-input.group>

        <div class="flex items-center justify-between text-sm">
            <x-input.checkbox label="Remember me" for="remember" id="remember" name="remember" class="h-4 w-4" />

            <div class="text-sm">
                <a href="{{ route('password.request') }}" class="font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                    Forgot your password?
                </a>
            </div>
        </div>

        <div>
            <x-button type="submit" color="blue" :full-width="true">
                Sign in
            </x-button>
        </div>
    </x-form>
@endsection
