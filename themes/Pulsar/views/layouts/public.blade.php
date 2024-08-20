@extends($meta->structure)

@push('styles')
    <link rel="stylesheet" href="{{ asset('themes/Pulsar/design/theme.css') }}" />
@endpush

@section('layout')
    <svg
        xmlns="http://www.w3.org/2000/svg"
        version="1.1"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        xmlns:svgjs="http://svgjs.dev/svgjs"
        viewBox="0 0 1066 800"
        class="fixed left-1/2 top-0 w-full -translate-x-1/2 opacity-15"
    >
        <defs>
            <linearGradient x1="50%" y1="0%" x2="50%" y2="100%" id="oooscillate-grad">
                <stop stop-color="hsl(206, 75%, 49%)" stop-opacity="1" offset="0%"></stop>
                <stop stop-color="hsl(331, 90%, 56%)" stop-opacity="1" offset="100%"></stop>
            </linearGradient>
        </defs>
        <g stroke-width="2" stroke="url(#oooscillate-grad)" fill="none" stroke-linecap="round">
            <path d="M 0 720 Q 266.5 -100 533 400 Q 799.5 900 1066 720" opacity="0.19"></path>
            <path d="M 0 696 Q 266.5 -100 533 400 Q 799.5 900 1066 696" opacity="0.12"></path>
            <path d="M 0 672 Q 266.5 -100 533 400 Q 799.5 900 1066 672" opacity="0.14"></path>
            <path d="M 0 648 Q 266.5 -100 533 400 Q 799.5 900 1066 648" opacity="0.21"></path>
            <path d="M 0 624 Q 266.5 -100 533 400 Q 799.5 900 1066 624" opacity="0.53"></path>
            <path d="M 0 600 Q 266.5 -100 533 400 Q 799.5 900 1066 600" opacity="0.82"></path>
            <path d="M 0 576 Q 266.5 -100 533 400 Q 799.5 900 1066 576" opacity="0.60"></path>
            <path d="M 0 552 Q 266.5 -100 533 400 Q 799.5 900 1066 552" opacity="0.38"></path>
            <path d="M 0 528 Q 266.5 -100 533 400 Q 799.5 900 1066 528" opacity="0.13"></path>
            <path d="M 0 504 Q 266.5 -100 533 400 Q 799.5 900 1066 504" opacity="0.31"></path>
            <path d="M 0 480 Q 266.5 -100 533 400 Q 799.5 900 1066 480" opacity="0.52"></path>
            <path d="M 0 456 Q 266.5 -100 533 400 Q 799.5 900 1066 456" opacity="0.58"></path>
            <path d="M 0 432 Q 266.5 -100 533 400 Q 799.5 900 1066 432" opacity="0.71"></path>
            <path d="M 0 408 Q 266.5 -100 533 400 Q 799.5 900 1066 408" opacity="0.43"></path>
            <path d="M 0 384 Q 266.5 -100 533 400 Q 799.5 900 1066 384" opacity="0.12"></path>
            <path d="M 0 360 Q 266.5 -100 533 400 Q 799.5 900 1066 360" opacity="0.84"></path>
            <path d="M 0 336 Q 266.5 -100 533 400 Q 799.5 900 1066 336" opacity="0.89"></path>
            <path d="M 0 312 Q 266.5 -100 533 400 Q 799.5 900 1066 312" opacity="0.12"></path>
            <path d="M 0 288 Q 266.5 -100 533 400 Q 799.5 900 1066 288" opacity="0.78"></path>
            <path d="M 0 264 Q 266.5 -100 533 400 Q 799.5 900 1066 264" opacity="0.81"></path>
            <path d="M 0 240 Q 266.5 -100 533 400 Q 799.5 900 1066 240" opacity="0.09"></path>
            <path d="M 0 216 Q 266.5 -100 533 400 Q 799.5 900 1066 216" opacity="0.64"></path>
            <path d="M 0 192 Q 266.5 -100 533 400 Q 799.5 900 1066 192" opacity="0.32"></path>
            <path d="M 0 168 Q 266.5 -100 533 400 Q 799.5 900 1066 168" opacity="0.81"></path>
            <path d="M 0 144 Q 266.5 -100 533 400 Q 799.5 900 1066 144" opacity="0.74"></path>
            <path d="M 0 120 Q 266.5 -100 533 400 Q 799.5 900 1066 120" opacity="0.31"></path>
            <path d="M 0 96 Q 266.5 -100 533 400 Q 799.5 900 1066 96" opacity="0.83"></path>
            <path d="M 0 72 Q 266.5 -100 533 400 Q 799.5 900 1066 72" opacity="0.10"></path>
            <path d="M 0 48 Q 266.5 -100 533 400 Q 799.5 900 1066 48" opacity="0.98"></path>
        </g>
    </svg>

    <div class="content-container">
        <div class="content">
            <nav class="main-nav">
                <div class="leading-container">
                    <x-logos.nova class="h-6 w-auto"></x-logos.nova>
                </div>

                <div class="divider"></div>

                <x-public::menu :items="$meta->menu?->items"></x-public::menu>

                <div class="divider"></div>

                <div class="trailing-container">
                    <a href="{{ route('login') }}">Sign in</a>
                </div>
            </nav>

            <main>
                @yield('template')
            </main>
        </div>
    </div>
@endsection
