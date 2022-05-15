@extends('app')

@section('layout')
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-logos.nova class="mx-auto h-12 w-auto" />
        </div>

        <div class="mt-12 sm:mx-auto sm:w-full sm:max-w-2xl">
            <div class="bg-white shadow-xl sm:rounded-xl">
                @yield('content')
            </div>

            <div class="mt-12 flex items-center justify-center space-x-1.5 font-medium text-gray-500">
                <span>Built with &hearts; by</span>
                <a href="https://anodyne-productions.com" target="_blank">
                    <x-logos.anodyne text-color="text-gray-500" logo-color="text-gray-400" class="h-5 w-auto" />
                </a>
            </div>
        </div>
    </div>
@endsection
