@props(['image', 'message', 'link', 'label'])

<x-panel>
    <div class="py-8 | md:py-16">
        <img src="/dist/svg/empty-states/{{ $image }}.svg" alt="" class="block h-72 w-auto mx-auto mb-8">

        <div class="flex flex-col items-center max-w-xs mx-auto | sm:max-w-sm md:max-w-xl">
            <div class="block text-center text-gray-700 mb-8 leading-relaxed">
                {{ $message }}
            </div>
            <a href="{{ $link }}" class="button button-primary">
                {{ $label }}
                @icon('arrow-right', 'h-5 w-5 ml-3 flex-shrink-0')
            </a>
        </div>
    </div>
</x-panel>
