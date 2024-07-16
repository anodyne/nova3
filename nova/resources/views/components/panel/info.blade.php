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
        class="rounded-lg bg-info-50 text-info-600 ring-1 ring-inset ring-info-300 dark:bg-info-950 dark:text-info-400 dark:ring-info-700"
    >
        <div class="flex items-start space-x-4">
            @if ($icon)
                <div class="shrink-0">
                    <x-icon :name="$icon" size="xl" class="text-info-600 dark:text-info-400"></x-icon>
                </div>
            @endif

            <div class="flex-1 space-y-2 md:flex md:flex-col md:justify-between">
                @if ($title)
                    <h3 class="text-base font-medium text-info-700 dark:text-info-300">
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
