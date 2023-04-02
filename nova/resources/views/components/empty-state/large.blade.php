@props([
    'icon',
    'title' => false,
    'message' => false,
    'link',
    'label',
    'linkAccess' => false,
])

<div class="py-8 md:py-16">
    <div class="flex flex-col items-center max-w-xs mx-auto sm:max-w-sm md:max-w-xl space-y-6">
        <div class="text-center">
            <x-badge color="primary" size="circle-lg" icon>
                @icon($icon, 'h-12 w-12')
            </x-badge>
        </div>

        <div class="space-y-3">
            @if ($title)
                <h2 class="text-center font-semibold text-gray-900 dark:text-gray-100">
                    {{ $title }}
                </h2>
            @endif

            @if ($message)
                <p class="text-center text-gray-600 dark:text-gray-300 leading-relaxed">
                    {{ $message }}
                </p>
            @endif
        </div>

        @if ($linkAccess)
            <x-button-filled tag="a" :href="$link" class="space-x-3">
                <span>{{ $label }}</span>
            </x-button-filled>
        @endif
    </div>
</div>
