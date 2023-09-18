@props([
    'title',
    'icon',
    'color',
    'notification',
])

<div class="flex items-start space-x-4">
    <x-badge :color="$color" size="circle">
        <x-icon :name="$icon" size="md"></x-icon>
    </x-badge>

    <div class="flex w-full flex-col">
        <div class="flex items-center justify-between">
            <h2 class="text-sm font-medium text-gray-500">{{ $title }}</h2>

            @if ($notification['unread'])
                <div>
                    <button
                        wire:click="markNotificationAsRead('{{ $notification['id'] }}')"
                        type="button"
                        class="group ml-6 shrink-0 rounded-full border-4 border-transparent transition hover:border-primary-100 dark:hover:border-primary-900"
                    >
                        <div
                            class="h-2.5 w-2.5 rounded-full bg-primary-500 group-hover:bg-primary-600 dark:group-hover:bg-primary-400"
                        ></div>
                    </button>
                </div>
            @else
                <div>
                    <x-button.text
                        wire:click="clearNotification('{{ $notification['id'] }}')"
                        color="subtle-neutral"
                        class="ml-6 shrink-0"
                    >
                        <x-icon.x-circle class="h-4 w-4"></x-icon.x-circle>
                    </x-button.text>
                </div>
            @endif
        </div>

        <div class="text-base text-gray-600 dark:text-gray-400">
            {{ $slot }}
        </div>

        <p class="mt-2 text-sm font-medium text-gray-400 dark:text-gray-600">{{ data_get($notification, 'date') }}</p>
    </div>
</div>
