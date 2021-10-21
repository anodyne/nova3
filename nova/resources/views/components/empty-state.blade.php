@props(['image', 'message', 'link', 'label'])

<x-panel>
    <div class="py-8 md:py-16">
        @svg("empty-{$image}", 'text-blue-9 block h-72 w-auto mx-auto mb-8')

        <div class="flex flex-col items-center max-w-xs mx-auto sm:max-w-sm md:max-w-xl">
            <div class="block text-center text-gray-11 mb-8 text-lg leading-relaxed">
                {{ $message }}
            </div>
            <x-link :href="$link" color="blue" class="space-x-3">
                <span>{{ $label }}</span>
            </x-link>
        </div>
    </div>
</x-panel>
