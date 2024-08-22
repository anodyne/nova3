@props([
    'character' => null,
    'position' => null,
    'orientation' => 'center',
    'options' => [],
])

<a
    {{
        $attributes->class([
            'flex flex-col rounded-lg bg-white px-4 py-6 shadow ring-1 ring-gray-950/5 transition hover:shadow-lg dark:bg-gray-900 dark:ring-inset dark:ring-white/5 dark:hover:ring-white/10',
            'items-center' => $orientation === 'center',
        ])
    }}
>
    @if (filled($character?->avatar_url) && in_array('avatar', $options))
        <x-avatar :src="$character->avatar_url" size="xl"></x-avatar>
    @endif

    <div
        @class([
            'mt-4 flex flex-col',
            'items-center' => $orientation === 'center',
        ])
    >
        <div class="flex items-center text-lg/7 font-bold tracking-tight text-gray-900 dark:text-white">
            @if (filled($character))
                {{ in_array('rank-name', $options) ? $character->display_name : $character->name }}
            @else
                {{ $position->name }}
            @endif
        </div>
        <div class="text-sm/6 text-gray-600 dark:text-gray-400">
            @if (filled($character))
                @if (in_array('position', $options))
                    {{ $position?->name ?? $character?->positions->implode('name', ' & ') }}
                @endif
            @else
                Position available
            @endif
        </div>

        @if (filled($character) && in_array('rank-image', $options))
            <div class="mt-4">
                <x-rank :rank="$character?->rank"></x-rank>
            </div>
        @endif

        <div class="mt-1">
            @if (filled($character))
                @if (in_array('type', $options))
                    <x-badge :color="$character->type->color()">{{ $character->type->getLabel() }}</x-badge>
                @endif

                @if (in_array('status', $options))
                    <x-badge :color="$character->status->color()">
                        {{ $character->status->getLabel() }}
                    </x-badge>
                @endif
            @else
                <x-badge color="gray">Apply today &rarr;</x-badge>
            @endif
        </div>
    </div>
</a>
