@extends($meta->template)

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
                <x-link :href="route('password.request')" color="blue-text" size="none">
                    Forgot your password?
                </x-link>
            </div>
        </div>

        <div>
            <x-button type="submit" color="blue" full-width>
                Sign in
            </x-button>
        </div>
    </x-form>
@endsection
