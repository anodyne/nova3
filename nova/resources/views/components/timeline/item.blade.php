@props([
    'title',
    'highlighted' => false,
    'last' => false,
])

<li class="relative flex flex-col gap-2" {{ $attributes->except(['class', 'style']) }}>
    <span
        class="absolute left-0 grid justify-center bg-transparent transition-opacity duration-200"
        style="top: 24px; width: 12px; opacity: 1; height: calc(100% - 24px)"
    >
        <span @class([
            'h-full w-0.5 bg-gray-300 dark:bg-gray-700' => ! $last,
        ])></span>
    </span>

    <div class="flex h-6 items-center gap-6">
        <span
            @class([
                'relative z-[2] w-max flex-shrink-0 overflow-hidden rounded-full p-1.5 text-white',
                'ring-2 ring-offset-4 ring-offset-white dark:ring-offset-gray-900' => $highlighted,
                'ring-4 ring-white dark:ring-gray-900' => ! $highlighted,
                $attributes->get('class'),
            ])
            style="{{ $attributes->get('style') }}"
        ></span>

        {{ $title }}
    </div>

    <div class="flex gap-6 pb-8">
        <span class="pointer-events-none invisible h-full flex-shrink-0" style="width: 12px"></span>
        {{ $slot }}
    </div>
</li>
