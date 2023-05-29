@props([
    'icon' => false,
    'title' => false,
    'height' => 'sm',
    'width' => 'sm',
])

<x-panel as="no-shadow" {{ $attributes }}>
    <x-content-box :height="$height" :width="$width" class="sm:rounded-lg ring-1 bg-danger-25 dark:bg-danger-950 ring-danger-300 dark:ring-danger-700 text-danger-600 dark:text-danger-400">
        <div class="flex items-start space-x-4">
            @if ($icon)
                <div class="shrink-0">
                    <x-icon :name="$icon" size="xl" class="text-danger-600 dark:text-danger-400"></x-icon>
                </div>
            @endif

            <div class="flex-1 md:flex md:flex-col md:justify-between space-y-2">
                @if ($title)
                    <h3 class="text-base font-medium text-danger-700 dark:text-danger-300">
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
