@extends($meta->structure)

@push('styles')
    <style>
        :root {
            --accent-color: {{ theme('settings')->accentColor() }};
            --text-accent-color: {{ theme('settings')->textAccentColor() }};
        }
    </style>
    <link rel="stylesheet" href="{{ asset('themes/Pulsar/design/theme.css') }}" />
@endpush

@section('layout')
    <nav class="main-nav">
        <div class="logo">
            <x-logos.nova class="h-6 w-auto"></x-logos.nova>
        </div>

        <div class="nav-container">
            <x-public::menu :items="$meta->menu?->items"></x-public::menu>
        </div>

        <div class="auth-ctn">
            @guest
                <a href="{{ route('login') }}">Sign in</a>
            @endguest

            @auth
                <a href="{{ route('admin.dashboard') }}">Dashboard &rarr;</a>
            @endauth
        </div>
    </nav>

    <div class="content-ctn">
        <div class="content">
            <main>
                @yield('template')
            </main>
        </div>
    </div>
@endsection
