<x-modal.slide-over title="Notifications" icon="bell">
    @forelse ($notifications as $notification)
        <div class="flex justify-between gap-x-6">
            @include("notifications.{$notification['type']}", compact('notification'))

            <div class="shrink-0">
                <x-dropdown placement="bottom-end">
                    <x-slot name="trigger">
                        <x-icon name="more"></x-icon>
                    </x-slot>

                    <x-dropdown.group>
                        <x-dropdown.item wire:click="markNotificationAsRead({{ $notification['id'] }})" icon="check">
                            Mark as read
                        </x-dropdown.item>
                        <x-dropdown.item-danger wire:click="clearNotification({{ $notification['id'] }})" icon="trash">
                            Clear notification
                        </x-dropdown.item-danger>
                    </x-dropdown.group>
                </x-dropdown>
            </div>
        </div>
    @empty
        <x-panel.primary
            icon="check"
            title="You’re all caught up"
            description="You don’t have any unread notifications"
        ></x-panel.primary>
    @endforelse

    <x-slot name="footer">
        <x-button :href="route('admin.account.notifications')" color="neutral" text>
            Manage your notifications
        </x-button>
    </x-slot>
</x-modal.slide-over>
