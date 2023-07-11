<div>
    <x-content-box width="sm">
        <div class="flex items-center space-x-2">
            <x-icon name="bell" size="md" class="shrink-0 text-gray-600 dark:text-gray-500"></x-icon>
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">Notification: {{ $notification->name }}</h3>
        </div>
    </x-content-box>

    @if ($notification->type === Nova\Foundation\Enums\SystemNotificationType::personal)
        @if ($user === null)
            <x-panel.warning icon="warning" title="You are editing the global setting" class="mt-6 mx-6">
                <div class="space-y-4">
                    <p>If you want to update your personal preference for this notification, click the button below to switch to your personal preference setting.</p>

                    <div>
                        <x-button.filled type="button" wire:click="switchToPersonalSetting" color="warning">Switch to personal preference setting</x-button.outline>
                    </div>
                </div>
            </x-panel.warning>
        @endif

        @if ($user !== null)
            <x-panel.primary icon="warning" title="You are editing your personal preference setting" class="mt-6 mx-6">
                <div class="space-y-4">
                    <p>If you want to update the global setting for this notification, click the button below to switch to the global setting.</p>

                    <div>
                        <x-button.filled type="button" wire:click="switchToGlobalSetting" color="primary">Switch to global setting</x-button.filled>
                    </div>
                </div>
            </x-panel.primary>
        @endif
    @endif

    <x-content-box height="none">
        <x-content-box width="none">
            <x-h3>Email</x-h3>
            <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                    @if ($user !== null)
                        <p>When triggered, this notification will be emailed to <strong class="font-semibold">{{ $user?->email }}</strong>.</p>
                    @else
                        <p>When triggered, this notification will be emailed to any user who has enabled it in their preferences.</p>
                    @endif
                </div>
                <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                    <x-switch-toggle name="default" :value="old('default')"></x-switch-toggle>
                </div>
            </div>
        </x-content-box>

        <x-content-box width="none" class="border-t border-gray-200 dark:border-gray-700">
            <x-h3>In-app</x-h3>
            <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                    @if ($user !== null)
                        <p>When triggered, this notification will be sent to the Notifications panel inside of Nova. When you have unread notifications, you will see an indicator on the notifications icon in the header.</p>
                    @else
                        <p>When triggered, this notification will be sent to the Notifications panel inside of Nova. Any user who has enabled it in their preferences will see an indicator on the notifications icon in the header.</p>
                    @endif
                </div>
                <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                    <x-switch-toggle name="default" :value="old('default')"></x-switch-toggle>
                </div>
            </div>
        </x-content-box>

        @if ($notification->type !== Nova\Foundation\Enums\SystemNotificationType::personal)
            <x-content-box width="none" class="border-t border-gray-200 dark:border-gray-700">
                <x-h3>Discord</x-h3>
                <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                    <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                        <p>When triggered, this notification will be sent to the Discord server specified with the settings below.</p>
                    </div>
                    <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                        <x-switch-toggle name="default" :value="old('default')"></x-switch-toggle>
                    </div>
                </div>
            </x-content-box>
        @endif
    </x-content-box>

    <x-content-box class="z-20 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse bg-gray-50 dark:bg-gray-700/50 rounded-b-lg" height="sm" width="sm">
        <x-button.filled color="primary" wire:click="apply">Apply</x-button.filled>

        <x-button.outline color="gray" wire:click="dismiss">Cancel</x-button.outline>
    </x-content-box>
</div>
