@props([
    'icon',
    'message',
    'link',
    'label',
    'linkAccess' => false,
])

<x-panel>
    <div class="py-8 md:py-16">
        @icon($icon, 'block h-20 w-20 mx-auto mb-8')

        <div class="flex flex-col items-center max-w-xs mx-auto sm:max-w-sm md:max-w-xl">
            <div class="block text-center text-gray-600 dark:text-gray-300 mb-8 text-lg leading-relaxed">
                {{ $message }}
            </div>

            @if ($linkAccess)
                <x-link :href="$link" color="primary" class="space-x-3">
                    <span>{{ $label }}</span>
                </x-link>
            @endif
        </div>
    </div>
</x-panel>
