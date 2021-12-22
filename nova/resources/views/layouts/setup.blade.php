@extends('app')

@section('layout')
    <div class="min-h-screen bg-gray-3 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-logos.nova class="mx-auto h-12 w-auto" />
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-2xl">
            <div class="bg-gray-1 shadow-xl sm:rounded-xl">
                @yield('content')
            </div>
        </div>
    </div>
@endsection
