@extends($__novaTemplate)

@section('content')
    <x-page-header title="Dashboard" />

    <x-panel class="p-6">
        <p>Welcome to Nova 3.</p>

        @php
            $user = Nova\Users\Models\User::first();
        @endphp

        <button x-on:click="$dispatch('modal-load', {{ json_encode($user) }})" class="mt-6 button button-primary">
            Open
        </button>
    </x-panel>

    <x-modal icon="delete" headline="Delete account?" color="red" :load-url="route('modal-test')" />
@endsection
