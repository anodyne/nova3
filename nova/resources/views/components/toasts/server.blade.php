@props(['notification'])

@if ($notification !== null)
    <div
        x-cloak
        x-data="{ show: true }"
        x-init="setTimeout(() => { show = false }, 5000)"
        x-show="show"
        x-description="Notification panel, show/hide based on alert state."
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto"
    >
        <div class="rounded-lg shadow-xs overflow-hidden">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        @if ($notification['type'] === 'success')
                            @icon('check-alt', 'h-6 w-6 text-green-500')
                        @else
                            @icon('alert', 'h-6 w-6 text-red-500')
                        @endif
                    </div>

                    <div class="ml-3 w-0 flex-1">
                        <p class="text-sm leading-5 font-medium text-gray-900">
                            {{ data_get($notification, 'detail.title') }}
                        </p>

                        @if (data_get($notification, 'detail.message'))
                            <p class="mt-1 text-sm leading-5 text-gray-500">
                                {{ data_get($notification, 'detail.message') }}
                            </p>
                        @endif
                    </div>

                    <div class="ml-4 flex-shrink-0 flex">
                        <button x-on:click="show = false" class="inline-flex text-gray-400 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                            @icon('close', 'h-5 w-5')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
