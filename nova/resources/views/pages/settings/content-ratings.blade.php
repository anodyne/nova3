<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            <x-slot name="actions">
                <x-button.find-setting />
            </x-slot>
        </x-page-heading>

        <x-tab.group>
            <x-slot name="tabs">
                <x-tab name="language">Language</x-tab>
                <x-tab name="sex">Sex</x-tab>
                <x-tab name="violence">Violence</x-tab>
            </x-slot>

            <x-tab.panel name="language">
                <livewire:settings-content-ratings category="language" />
            </x-tab.panel>

            <x-tab.panel name="sex">
                <livewire:settings-content-ratings category="sex" />
            </x-tab.panel>

            <x-tab.panel name="violence">
                <livewire:settings-content-ratings category="violence" />
            </x-tab.panel>
        </x-tab.group>
    </x-spacing>
</x-admin-layout>
