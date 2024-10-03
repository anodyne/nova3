<x-admin-layout>
    <x-page-header>
        <x-slot name="actions">
            <div x-data="{}">
                <x-button x-on:click="$dispatch('toggle-spotlight')" color="neutral">
                    <x-icon name="search" size="sm"></x-icon>
                    Find a setting
                </x-button>
            </div>
        </x-slot>
    </x-page-header>

    <livewire:settings-notification-types-list />
</x-admin-layout>
