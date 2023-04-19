@extends('app')

@section('layout')
    <div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            @if (app('nova.settings')->getFirstMedia('logo'))
                <div>
                    <img src="{{ app('nova.settings')->getFirstMediaUrl('logo') }}" alt="logo" class="mx-auto h-12 w-auto">
                </div>
            @else
                <x-logos.nova class="mx-auto h-12 w-auto" />
            @endif

            <x-h1 class="mt-6 text-center">
                @yield('page-header')
            </x-h1>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-xl sm:rounded-xl sm:px-10 ring-1 ring-gray-900/5">
                @yield('content')
            </div>
        </div>
    </div>
@endsection
