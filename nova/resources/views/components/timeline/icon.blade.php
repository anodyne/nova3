@props([
    'title',
    'icon',
    'highlighted' => false,
    'last' => false,
])

<li class="relative flex flex-col gap-2" {{ $attributes->except(['class', 'style']) }}>
    <span
        class="absolute left-0 top-12 grid h-[calc(100%-theme(spacing.12))] w-8 justify-center bg-transparent transition-opacity duration-200"
        {{-- style="top: 36px; width: 36px; opacity: 1; height: calc(100% - 36px)" --}}
    >
        <span @class([
            'h-full w-0.5 bg-gray-300 dark:bg-gray-700' => ! $last,
        ])></span>
    </span>

    <div class="flex h-12 items-center gap-6">
        <span
            @class([
                'relative z-[2] w-max flex-shrink-0 overflow-hidden rounded-full p-1.5 text-white',
                'ring-2 ring-offset-4 ring-offset-white dark:ring-offset-gray-900' => $highlighted,
                'ring-[8px] ring-white dark:ring-gray-900' => ! $highlighted,
                $attributes->get('class'),
            ])
            style="{{ $attributes->get('style') }}"
        >
            <x-icon :name="$icon" size="sm"></x-icon>
        </span>

        {{ $title }}
    </div>

    <div class="flex gap-6 pb-8">
        <span class="pointer-events-none invisible h-full w-8 flex-shrink-0"></span>
        {{ $slot }}
    </div>
</li>
