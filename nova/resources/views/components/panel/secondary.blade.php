@props([
    'icon' => false,
    'title' => false,
    'height' => 'sm',
    'width' => 'sm',
])

<x-panel as="no-shadow" {{ $attributes }}>
    <x-content-box :height="$height" :width="$width" class="sm:rounded-lg ring-1 bg-secondary-25 dark:bg-secondary-950 ring-secondary-300 dark:ring-secondary-700 text-secondary-600 dark:text-secondary-400">
        <div class="flex items-start space-x-4">
            @if ($icon)
                <div class="shrink-0">
                    <x-icon :name="$icon" size="xl" class="text-secondary-600 dark:text-secondary-400"></x-icon>
                </div>
            @endif

            <div class="flex-1 md:flex md:flex-col md:justify-between space-y-2">
                @if ($title)
                    <h3 class="text-base font-medium text-secondary-700 dark:text-secondary-300">
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
