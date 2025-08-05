<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                <div x-data="{}">
                    <x-button x-on:click="$dispatch('toggle-spotlight')" color="neutral">
                        <x-icon :name="Icon::Search" size="sm"></x-icon>
                        Find a setting
                    </x-button>
                </div>
            </x-slot>
        </x-page-header>

        <livewire:settings-posting-activity />
    </x-spacing>
</x-admin-layout>
