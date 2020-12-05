@extends('app')

@section('layout')
    <div class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 | sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-nova-logo class="mx-auto h-12 w-auto text-blue-600" />

            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                @yield('page-header')
            </h2>
        </div>

        <div class="mt-8 | sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-lg | sm:rounded-lg sm:px-10">
                @yield('template')
            </div>
        </div>
    </div>
@endsection
