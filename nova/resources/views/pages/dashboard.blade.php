@extends($__novaTemplate)

@section('content')
    <x-page-header title="Dashboard" />

    <x-panel class="p-6">
        <p class="mb-8">Welcome to Nova 3.</p>

        {{-- <x-modal title="Delete account?" class="button-primary">
            <x-slot name="trigger">Open Modal</x-slot>

            <p class="text-sm leading-5 text-gray-500">
                Are you sure you want to deactivate your account? All of your data will be permanently removed from our servers forever. This action cannot be undone.
            </p>
        </x-modal> --}}

        <dropdown class="button">
            Options

            <template #dropdown>
                <a href="#" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">Account settings</a>
                <a href="#" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">Account settings</a>
                <a href="#" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">Account settings</a>
            </template>
        </dropdown>
    </x-panel>
@endsection
