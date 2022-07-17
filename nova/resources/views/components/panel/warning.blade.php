@props([
    'icon' => false,
    'title' => false,
    'height' => 'sm',
    'width' => 'sm',
])

<x-panel as="no-shadow" {{ $attributes }}>
    <x-content-box :height="$height" :width="$width" class="sm:rounded-lg border-y sm:border-x bg-warning-50 dark:bg-warning-900/50 border-warning-300 dark:border-warning-700 text-warning-600 dark:text-warning-500">
        <div class="flex items-start space-x-4">
            @if ($icon)
                <div class="shrink-0">
                    @icon($icon, 'h-7 w-7 md:h-6 md:w-6 text-warning-500 dark:text-warning-600')
                </div>
            @endif

            <div class="flex-1 md:flex md:flex-col md:justify-between space-y-4">
                @if ($title)
                    <h3 class="text-base font-medium text-warning-700 dark:text-warning-300">
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
