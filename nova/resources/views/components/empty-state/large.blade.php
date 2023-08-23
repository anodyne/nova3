@props([
    'icon',
    'title' => false,
    'message' => false,
    'link',
    'label',
    'linkAccess' => false,
])

<div class="py-8 md:py-16">
    <div class="mx-auto flex max-w-xs flex-col items-center space-y-6 sm:max-w-sm md:max-w-xl">
        <div class="text-center">
            <x-icon :name="$icon" size="h-16 w-16" class="text-primary-500 dark:text-primary-400"></x-icon>
        </div>

        <div class="space-y-3">
            @if ($title)
                <h2 class="text-center font-semibold text-gray-900 dark:text-white">
                    {{ $title }}
                </h2>
            @endif

            @if ($message)
                <p class="text-center leading-relaxed text-gray-600 dark:text-gray-300">
                    {{ $message }}
                </p>
            @endif
        </div>

        @if ($linkAccess)
            <x-button.filled :href="$link" class="space-x-3" color="primary">
                {{ $label }}
            </x-button.filled>
        @endif
    </div>
</div>
