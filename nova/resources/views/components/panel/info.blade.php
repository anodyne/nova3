@props([
    'icon' => false,
    'title' => false,
    'height' => 'sm',
    'width' => 'sm',
])

<x-panel as="no-shadow" {{ $attributes }}>
    <x-content-box :height="$height" :width="$width" class="sm:rounded-lg ring-1 bg-info-25 dark:bg-info-900/30 ring-info-300 dark:ring-info-700 text-info-600 dark:text-info-400">
        <div class="flex items-start space-x-4">
            @if ($icon)
                <div class="shrink-0">
                    @icon($icon, 'h-7 w-7 md:h-6 md:w-6 text-info-600 dark:text-info-400')
                </div>
            @endif

            <div class="flex-1 md:flex md:flex-col md:justify-between space-y-2">
                @if ($title)
                    <h3 class="text-base font-medium text-info-700 dark:text-info-300">
                        {{ $title }}
                    </h3>
                @endif

                <div class="text-base md:text-sm">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </x-content-box>
</x-panel>
