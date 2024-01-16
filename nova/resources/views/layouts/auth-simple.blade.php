@extends('app')

@section('layout')
    <div class="flex min-h-screen flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="relative z-10 sm:mx-auto sm:w-full sm:max-w-md">
            @if (app('nova.settings')->getFirstMedia('logo'))
                <div>
                    <img
                        src="{{ app('nova.settings')->getFirstMediaUrl('logo') }}"
                        alt="logo"
                        class="mx-auto h-12 w-auto"
                    />
                </div>
            @else
                <x-logos.nova class="mx-auto h-12 w-auto" />
            @endif

            <x-h1 class="mt-6 text-center">
                @yield('page-header')
            </x-h1>
        </div>

        <div class="z-10 mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            @yield('content')
        </div>
    </div>
@endsection
