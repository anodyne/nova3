@props([
    'src',
    'tooltip' => '',
    'size' => 'md',
    'primary' => '',
    'secondary' => '',
])

<div class="inline-flex items-center">
    <x-avatar :src="$src" :tooltip="$tooltip" :size="$size"></x-avatar>

    @if ($primary || $secondary)
        <div class="flex flex-col ml-4">
            @if ($primary)
                <div class="flex items-center font-medium truncate text-gray-900 dark:text-white">
                    {{ $primary }}
                </div>
            @endif

            @if ($secondary)
                <div class="mt-0.5 flex items-center text-sm text-gray-600 dark:text-gray-400">
                    {{ $secondary }}
                </div>
            @endif
        </div>
    @endif
</div>
