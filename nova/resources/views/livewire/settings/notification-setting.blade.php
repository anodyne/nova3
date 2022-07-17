<div>
    <x-content-box width="sm">
        <div class="flex items-center space-x-2">
            @icon('notification', 'h-6 w-6 shrink-0 text-gray-600 dark:text-gray-500')
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">Notification: {{ $notification->name }}</h3>
        </div>
    </x-content-box>

{{--    <x-panel.warning icon="warning" title="You are editing the global setting" class="mt-6 mx-6">--}}
{{--        <div class="space-y-4">--}}
{{--            <p>If you were intending to update your personal preference for this notification, you can click the button below to switch to your personal preference setting.</p>--}}

{{--            <div>--}}
{{--                <x-button type="button" color="warning-outline">Switch to personal preference setting</x-button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </x-panel.warning>--}}

    <x-panel.info icon="warning" title="You are editing your personal preference setting" class="mt-6 mx-6">
        <div class="space-y-4">
            <p>If you were intending to update the global setting for this notification, you can click the button below to switch to the global setting.</p>

            <div>
                <x-button type="button" color="info-outline">Switch to global setting</x-button>
            </div>
        </div>
    </x-panel.info>

    <x-content-box height="none">
        <x-content-box width="none">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="renew-subscription-label">Email</h3>
            <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl text-sm text-gray-500">
                    <p id="renew-subscription-description">When triggered, this notification will be emailed to <strong class="font-semibold">admin@admin.com</strong>.</p>
                </div>
                <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                    <x-input.toggle field="default" :value="old('default')"></x-input.toggle>
                </div>
            </div>
        </x-content-box>

        <x-content-box width="none" class="border-t border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="renew-subscription-label">In-app</h3>
            <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                <div class="max-w-xl text-sm text-gray-500">
                    <p id="renew-subscription-description">When triggered, this notification will be sent to the Notifications panel inside of Nova. When you have unread notifications, you will see an indicator on the notifications icon in the header.</p>
                </div>
                <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                    <x-input.toggle field="default" :value="old('default')"></x-input.toggle>
                </div>
            </div>
        </x-content-box>

        @if ($notification->category === 'group')
            <x-content-box width="none" class="border-t border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="renew-subscription-label">Discord</h3>
                <div class="mt-2 sm:flex sm:items-start sm:justify-between">
                    <div class="max-w-xl text-sm text-gray-500">
                        <p id="renew-subscription-description">When triggered, this notification will be sent to the Discord server you specify with the settings below.</p>
                    </div>
                    <div class="mt-5 sm:mt-0 sm:ml-6 sm:flex-shrink-0 sm:flex sm:items-center">
                        <x-input.toggle field="default" :value="old('default')"></x-input.toggle>
                    </div>
                </div>
            </x-content-box>
        @endif
    </x-content-box>

    <x-content-box class="z-20 sm:flex sm:flex-row-reverse sm:space-x-4 sm:space-x-reverse bg-gray-50 dark:bg-gray-700/50 rounded-b-lg" height="sm" width="sm">
        <x-button color="primary" wire:click="apply">Apply</x-button>

        <x-button color="white" wire:click="dismiss">Cancel</x-button>
    </x-content-box>
</div>
