@extends('app')

@section('layout')
    <div class="min-h-screen bg-gray-3 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-logos.nova class="mx-auto h-10 w-auto" />

            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-12">
                @yield('page-header')
            </h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-gray-1 py-8 px-4 shadow-xl sm:rounded-xl sm:px-10">
                @yield('template')
            </div>
        </div>
    </div>
@endsection
