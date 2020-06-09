@extends('app')

@section('layout')
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 | sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-nova-logo class="mx-auto h-12 w-auto text-blue-500" />

            <h2 class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                Setup Nova 3
            </h2>
        </div>

        <div class="mt-8 | sm:mx-auto sm:w-full sm:max-w-2xl">
            <div class="bg-white shadow | sm:rounded-lg">
                @yield('content')
            </div>
        </div>
    </div>
@endsection
