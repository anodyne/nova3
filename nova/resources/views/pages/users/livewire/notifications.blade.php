@use('Nova\Users\Enums\NotificationStatus')

<x-modal.slide-over title="Notifications" :icon="Tabler::Bell">
    <nav class="flex items-center justify-between">
        <x-radio.group wire:model.live="status" variant="segmented" class="max-w-fit">
            @foreach (NotificationStatus::cases() as $notificationStatus)
                <x-radio :value="$notificationStatus->value">
                    {{ $notificationStatus->getLabel() }}

                    @if ($notificationStatus === NotificationStatus::Unread && $unreadCount > 0)
                        <x-badge color="primary">{{ $unreadCount }}</x-badge>
                    @endif
                </x-radio>
            @endforeach
        </x-radio.group>

        @if ($unreadCount > 0)
            <x-button
                wire:click="markAllNotificationsAsRead"
                size="sm"
                inset="right top bottom"
                variant="ghost"
                :loading="false"
            >
                <x-icon :name="Tabler::Checks" size="sm" />
                Mark all as read
            </x-button>
        @endif

        @if ($unreadCount === 0 && $allCount > 0 && $status === NotificationStatus::All)
            <x-button wire:click="clearAllNotifications" size="sm" inset="right top bottom" variant="ghost">
                Clear all
            </x-button>
        @endif
    </nav>

    <div class="space-y-6">
        @forelse ($notifications as $boundary => $boundaryNotifications)
            <div class="space-y-3">
                <h3 class="text-sm font-medium text-gray-500">
                    {{ str($boundary)->replace('_', ' ')->title() }}
                </h3>

                @foreach ($boundaryNotifications as $notification)
                    @include("notifications.{$notification['type']}", compact('notification'))
                @endforeach
            </div>
        @empty
            <x-empty>
                <x-empty.heading>You’re all up to date</x-empty.heading>

                @if ($status === NotificationStatus::Unread)
                    <x-empty.text>There are no new notifications at the moment</x-empty.text>
                @else
                    <x-empty.text>There are no notifications at the moment</x-empty.text>
                @endif
            </x-empty>
        @endforelse
    </div>

    <x-slot name="footer">
        <x-button :href="route('admin.account.notifications')" size="sm" inset="left top bottom" variant="ghost">
            Manage your notifications
        </x-button>
    </x-slot>
</x-modal.slide-over>
