<div>
    <x-spacing width="sm">
        <div class="flex items-center space-x-2">
            <x-icon name="bell" size="md" class="shrink-0 text-gray-600 dark:text-gray-500"></x-icon>
            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100" id="modal-title">
                Notification: {{ $notification->name }}
            </h3>
        </div>
    </x-spacing>

    @if ($notification->type === Nova\Foundation\Enums\NotificationAudience::personal)
        @if ($user === null)
            <x-panel.warning icon="warning" title="You are editing the global setting" class="mx-6 mt-6">
                <div class="space-y-4">
                    <p>
                        If you want to update your personal preference for this notification, click the button below to
                        switch to your personal preference setting.
                    </p>

                    <div>
                        <x-button type="button" wire:click="switchToPersonalSetting" color="warning" text>
                            Switch to personal preference setting &rarr;
                        </x-button>
                    </div>
                </div>
            </x-panel.warning>
        @endif

        @if ($user !== null)
            <x-panel.primary icon="warning" title="You are editing your personal preference setting" class="mx-6 mt-6">
                <div class="space-y-4">
                    <p>
                        If you want to update the global setting for this notification, click the button below to switch
                        to the global setting.
                    </p>

                    <div>
                        <x-button type="button" wire:click="switchToGlobalSetting" color="primary" text>
                            Switch to global setting &rarr;
                        </x-button>
                    </div>
                </div>
            </x-panel.primary>
        @endif
    @endif

    <x-spacing height="none">
        <x-spacing width="none">
            <x-h3>Email</x-h3>
            <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                    @if ($user !== null)
                        <p>
                            When triggered, this notification will be emailed to
                            <strong class="font-semibold">{{ $user?->email }}</strong>
                            .
                        </p>
                    @else
                        <p>
                            When triggered, this notification will be emailed to any user who has enabled it in their
                            preferences.
                        </p>
                    @endif
                </div>
                <div class="mt-5 sm:ml-6 sm:mt-0 sm:flex sm:flex-shrink-0 sm:items-center">
                    <x-switch name="default" id="default1" :value="old('default')"></x-switch>
                </div>
            </div>
        </x-spacing>

        <x-spacing width="none" class="border-t border-gray-200 dark:border-gray-700">
            <x-h3>In-app</x-h3>
            <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                    @if ($user !== null)
                        <p>
                            When triggered, this notification will be sent to the Notifications panel inside of Nova.
                            When you have unread notifications, you will see an indicator on the notifications icon in
                            the header.
                        </p>
                    @else
                        <p>
                            When triggered, this notification will be sent to the Notifications panel inside of Nova.
                            Any user who has enabled it in their preferences will see an indicator on the notifications
                            icon in the header.
                        </p>
                    @endif
                </div>
                <div class="mt-5 sm:ml-6 sm:mt-0 sm:flex sm:flex-shrink-0 sm:items-center">
                    <x-switch name="default" id="default2" :value="old('default')"></x-switch>
                </div>
            </div>
        </x-spacing>

        @if ($notification->type !== Nova\Foundation\Enums\NotificationAudience::personal)
            <x-spacing width="none" class="border-t border-gray-200 dark:border-gray-700">
                <x-h3>Discord</x-h3>
                <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                    <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                        <p>
                            When triggered, this notification will be sent to the Discord server specified with the
                            settings below.
                        </p>
                    </div>
                    <div class="mt-5 sm:ml-6 sm:mt-0 sm:flex sm:flex-shrink-0 sm:items-center">
                        <x-switch name="default" id="default3" :value="old('default')"></x-switch>
                    </div>
                </div>
            </x-spacing>
        @endif
    </x-spacing>

    <x-spacing
        class="z-20 rounded-b-lg bg-gray-50 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse dark:bg-gray-700/50"
        size="sm"
    >
        <x-button wire:click="apply" color="primary">Apply</x-button>
        <x-button wire:click="dismiss" plain>Cancel</x-button>
    </x-spacing>
</div>
