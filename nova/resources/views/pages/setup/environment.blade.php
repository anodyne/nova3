@extends('layouts.setup')

@section('content')
    <x-content-box>
        <p>Unfortunately we can't continue with the Nova 3 setup due to issues detected with your server configuration. Please contact your web host to correct these issues and continue with the setup process.</p>

        <dl class="mt-6 space-y-3">
            @foreach ($errors as $error)
                <dt class="font-medium text-danger-500 flex space-x-3">
                    <span>&times;</span>
                    <span>{{ $error }}</span>
                </dt>
            @endforeach
        </dl>
    </x-content-box>
@endsection
