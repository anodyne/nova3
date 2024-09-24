@props([
    'content',
    'author' => null,
    'date' => null,
    'mine' => false,
])

<div
    @class([
        'space-y-1',
        'place-self-start pe-16' => ! $mine,
        'place-self-end ps-16' => $mine,
    ])
>
    <div
        @class([
            'space-y-6 rounded-lg px-4 py-3 text-sm/6 font-medium',
            'bg-gray-100 dark:bg-gray-800' => ! $mine,
            'bg-primary-100 text-primary-700 dark:bg-primary-950 dark:text-primary-500' => $mine,
        ])
    >
        {!! str($content)->markdown() !!}
    </div>
    <div
        @class([
            'flex items-center gap-x-4 text-xs/5 text-gray-400 dark:text-gray-600',
            'ps-1' => ! $mine,
            'pe-1 text-right' => $mine,
        ])
    >
        @if (filled($author))
            <div class="font-semibold">{{ $author }}</div>
        @endif

        @if (filled($date))
            <div>{{ $date->diffForHumans() }}</div>
        @endif
    </div>
</div>
