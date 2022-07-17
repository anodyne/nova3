@props([
    'icon' => false,
    'title' => false,
    'height' => 'sm',
    'width' => 'sm',
])

<x-panel as="no-shadow" {{ $attributes }}>
    <x-content-box :height="$height" :width="$width" class="sm:rounded-lg ring-1 bg-primary-25 dark:bg-primary-900/30 ring-primary-300 dark:ring-primary-700 text-primary-600 dark:text-primary-400">
        <div class="flex items-start space-x-4">
            @if ($icon)
                <div class="shrink-0">
                    @icon($icon, 'h-7 w-7 md:h-6 md:w-6 text-primary-600 dark:text-primary-400')
                </div>
            @endif

            <div class="flex-1 md:flex md:flex-col md:justify-between space-y-2">
                @if ($title)
                    <h3 class="text-base font-medium text-primary-700 dark:text-primary-300">
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
