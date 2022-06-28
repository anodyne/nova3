@props(['notification'])

@if ($notification !== null)
    <div
        x-cloak
        x-data="{ show: true }"
        x-init="setTimeout(() => { show = false }, 6000)"
        x-show="show"
        x-description="Notification panel, show/hide based on alert state."
        x-transition:enter="ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="max-w-sm w-full bg-white dark:bg-gray-700 shadow-lg dark:shadow-none dark:highlight-white/5 rounded-lg pointer-events-auto"
    >
        <div class="rounded-lg ring-1 ring-gray-900/5 overflow-hidden">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="shrink-0">
                        @if ($notification['type'] === 'success')
                            @icon('check', 'h-6 w-6 text-success-500')
                        @else
                            @icon('alert', 'h-6 w-6 text-error-500')
                        @endif
                    </div>

                    <div class="ml-3 w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ data_get($notification, 'detail.title') }}
                        </p>

                        @if (data_get($notification, 'detail.message'))
                            <p class="mt-1 text-sm text-gray-500">
                                {{ data_get($notification, 'detail.message') }}
                            </p>
                        @endif
                    </div>

                    <div class="ml-4 shrink-0 flex">
                        <x-button @click="show = false" color="gray-text" size="none">
                            @icon('close', 'h-5 w-5')
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
