<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            <x-slot name="actions">
                <x-button :href="route('admin.account.notifications')">
                    <x-icon :name="Tabler::Notification" size="sm" />
                    <span>Notifications</span>
                </x-button>
            </x-slot>
        </x-page-heading>

        <x-form action="" :space="false" class="mt-8">
            <livewire:my-account />
        </x-form>
    </x-spacing>
</x-admin-layout>
