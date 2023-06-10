@props([
    'icon' => false,
    'title' => false,
    'height' => 'sm',
    'width' => 'sm',
])

<x-panel as="no-shadow" {{ $attributes }}>
    <x-content-box :height="$height" :width="$width" class="border-y border-warning-300 bg-warning-50 text-warning-600 dark:border-warning-700 dark:bg-warning-950 dark:text-warning-500 sm:rounded-lg sm:border-x">
        <div class="flex items-start space-x-4">
            @if ($icon)
                <div class="shrink-0">
                    <x-icon :name="$icon" size="xl" class="text-warning-600 dark:text-warning-400"></x-icon>
                </div>
            @endif

            <div class="flex-1 space-y-4 md:flex md:flex-col md:justify-between">
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
