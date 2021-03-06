@props(['image', 'message', 'link', 'label'])

<x-panel>
    <div class="py-8 | md:py-16">
        @svg("empty-{$image}", 'text-blue-600 block h-72 w-auto mx-auto mb-8')

        <div class="flex flex-col items-center max-w-xs mx-auto | sm:max-w-sm md:max-w-xl">
            <div class="block text-center text-gray-700 mb-8 text-lg leading-relaxed">
                {{ $message }}
            </div>
            <x-button-link :href="$link" color="blue" class="space-x-3">
                <span>{{ $label }}</span>
                @icon('arrow-right', 'h-5 w-5 flex-shrink-0')
            </x-button-link>
        </div>
    </div>
</x-panel>
