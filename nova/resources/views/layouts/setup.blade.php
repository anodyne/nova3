@extends('app')

@section('layout')
    <div class="flex min-h-screen flex-col justify-center bg-gray-200 py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-logos.nova class="mx-auto h-12 w-auto" />
        </div>

        <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-2xl">
            <div class="bg-white shadow-xl ring-1 ring-gray-950/5 sm:rounded-xl">
                @yield('content')
            </div>

            <div class="mt-12 flex items-center justify-center space-x-1.5 text-gray-400">
                <span>Built with &hearts; by</span>
                <a href="https://anodyne-productions.com" target="_blank">
                    <x-logos.anodyne text-color="text-gray-400" logo-color="text-gray-300" class="h-5 w-auto" />
                </a>
            </div>
        </div>
    </div>
@endsection
