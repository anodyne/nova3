@php
    $themeSettings = theme('settings');
@endphp

@push('styles')
    <style>
        :root {
            --accent-color: {{ $themeSettings->accentColor() }};
            --text-accent-color: {{ $themeSettings->textAccentColor() }};
        }
    </style>
    <link rel="stylesheet" href="{{ asset('themes/Pulsar/design/theme.css') }}" />
@endpush

<x-public-layout>
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
                <a href="{{ route('admin.dashboard') }}">
                    Dashboard
                    <span aria-hidden="true">→</span>
                </a>
            @endauth
        </div>
    </nav>

    <div class="content-ctn">
        <div class="content">
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
</x-public-layout>
