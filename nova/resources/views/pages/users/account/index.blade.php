<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                <x-button :href="route('admin.account.notifications')">
                    <x-icon name="notification" size="sm"></x-icon>
                    <span>Notifications</span>
                </x-button>
            </x-slot>
        </x-page-header>

        <x-form action="" :space="false" class="mt-8">
            <livewire:my-account />
        </x-form>
    </x-spacing>
</x-admin-layout>
