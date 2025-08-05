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

        <flux:tab.group>
            <flux:tabs>
                <flux:tab name="language">Language</flux:tab>
                <flux:tab name="sex">Sex</flux:tab>
                <flux:tab name="violence">Violence</flux:tab>
            </flux:tabs>

            <flux:tab.panel name="language">
                <livewire:settings-content-ratings category="language" />
            </flux:tab.panel>

            <flux:tab.panel name="sex">
                <livewire:settings-content-ratings category="sex" />
            </flux:tab.panel>

            <flux:tab.panel name="violence">
                <livewire:settings-content-ratings category="violence" />
            </flux:tab.panel>
        </flux:tab.group>
    </x-spacing>
</x-admin-layout>
