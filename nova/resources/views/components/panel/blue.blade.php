@props([
    'icon' => false,
    'title' => false,
    'height' => 'sm',
    'width' => 'sm',
])

<x-panel as="no-shadow" {{ $attributes }}>
    <x-content-box :height="$height" :width="$width" class="sm:rounded-lg border-y sm:border-x bg-blue-50 dark:bg-blue-900/50 border-blue-300 dark:border-blue-700 text-blue-600 dark:text-blue-500">
        <div class="flex items-start space-x-4">
            @if ($icon)
                <div class="shrink-0">
                    @icon($icon, 'h-7 w-7 md:h-6 md:w-6 text-blue-500 dark:text-blue-600')
                </div>
            @endif

            <div class="flex-1 md:flex md:flex-col md:justify-between space-y-4">
                @if ($title)
                    <h3 class="text-lg md:text-base font-semibold">
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