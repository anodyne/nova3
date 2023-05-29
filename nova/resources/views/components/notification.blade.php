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

    <div class="flex flex-col w-full">
        <div class="flex items-center justify-between">
            <h2 class="text-xs uppercase tracking-wider font-semibold text-gray-500">{{ $title }}</h2>

            @if ($notification['unread'])
                <div>
                    <button wire:click="markNotificationAsRead('{{ $notification['id'] }}')" type="button" class="group rounded-full shrink-0 ml-6 border-4 border-transparent transition hover:border-primary-100 dark:hover:border-primary-900">
                        <div class="rounded-full h-2.5 w-2.5 bg-primary-500 group-hover:bg-primary-600 dark:group-hover:bg-primary-400"></div>
                    </button>
                </div>
            @else
                <div>
                    <x-button.text wire:click="clearNotification('{{ $notification['id'] }}')" color="light-gray" class="shrink-0 ml-6">
                        <x-icon.x-circle class="h-4 w-4"></x-icon.x-circle>
                    </x-button.text>
                </div>
            @endif
        </div>

        {{ $slot }}

        <p class="mt-2 text-sm text-gray-500">{{ data_get($notification, 'date') }}</p>
    </div>
</div>
