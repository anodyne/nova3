@props([
    'icon' => false,
    'title' => false,
    'height' => 'sm',
    'width' => 'sm',
])

<x-panel {{ $attributes }} no-shadow>
    <x-spacing
        :height="$height"
        :width="$width"
        class="rounded-lg bg-warning-50 text-warning-600 ring-1 ring-inset ring-warning-300 dark:bg-warning-950 dark:text-warning-400 dark:ring-warning-700"
    >
        <div class="flex items-start space-x-4">
            @if ($icon)
                <div class="shrink-0">
                    <x-icon :name="$icon" size="xl" class="text-warning-600 dark:text-warning-400"></x-icon>
                </div>
            @endif

            <div class="flex-1 space-y-2 md:flex md:flex-col md:justify-between">
                @if ($title)
                    <h3 class="text-base font-medium text-warning-700 dark:text-warning-300">
                        {{ $title }}
                    </h3>
                @endif

                <div class="text-base/7 md:text-sm/6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </x-spacing>
</x-panel>
