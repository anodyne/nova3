@props([
    'icon' => false,
    'title' => false,
    'height' => 'sm',
    'width' => 'sm',
])

<x-panel as="no-shadow" {{ $attributes }}>
    <x-content-box
        :height="$height"
        :width="$width"
        class="bg-danger-50 text-danger-600 ring-1 ring-inset ring-danger-300 dark:bg-danger-950 dark:text-danger-400 dark:ring-danger-700 sm:rounded-lg"
    >
        <div class="flex items-start space-x-4">
            @if ($icon)
                <div class="shrink-0">
                    <x-icon :name="$icon" size="xl" class="text-danger-600 dark:text-danger-400"></x-icon>
                </div>
            @endif

            <div class="flex-1 space-y-2 md:flex md:flex-col md:justify-between">
                @if ($title)
                    <h3 class="text-base font-medium text-danger-700 dark:text-danger-300">
                        {{ $title }}
                    </h3>
                @endif

                <div class="text-base/7 md:text-sm/6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </x-content-box>
</x-panel>
