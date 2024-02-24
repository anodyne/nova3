@props([
    'columns' => [],
    'character' => null,
    'position' => null,
])

<a
    class="flex items-center gap-x-4 rounded-lg px-3 py-3 transition hover:bg-gray-50 dark:hover:bg-gray-900"
    {{ $attributes }}
>
    @foreach ($columns as $column)
        <div
            @class([
                'flex items-center',
                'flex-1' => $column['width'] === 'fill',
            ])
            @style([
                "width:{$column['width']}" => $column['width'] !== 'fit' && $column['width'] !== 'fill',
            ])
        >
            @if ($column['column'] === 'rank-image')
                @if (filled($character?->rank))
                    <x-rank :rank="$character?->rank"></x-rank>
                @else
                    <div class="rank-base"></div>
                @endif
            @endif

            @if ($column['column'] === 'rank-name')
                @if (filled($character?->rank))
                    {{ $character?->rank?->name?->name }}
                @endif
            @endif

            @if ($column['column'] === 'position-name')
                {{ $position?->name ?? $character?->positions->implode('name', ' & ') }}
            @endif

            @if ($column['column'] === 'character-name')
                @if (filled($character))
                    <div class="inline-flex items-center gap-x-3">
                        @if (in_array('avatar', $column['characterOptions']))
                            <x-avatar :src="$character->avatar_url"></x-avatar>
                        @endif

                        <div class="flex flex-col">
                            <div class="flex items-center font-medium text-gray-900 dark:text-white">
                                {{ in_array('rank', $column['characterOptions']) ? $character->display_name : $character->name }}
                            </div>

                            @if (in_array('position', $column['characterOptions']))
                                <div class="text-sm/6 text-gray-600 dark:text-gray-400">
                                    {{ $position?->name ?? $character?->positions->implode('name', ' & ') }}
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="inline-flex items-center gap-x-3">
                        @if (in_array('avatar', $column['characterOptions']))
                            <div class="size-12"></div>
                        @endif

                        <div class="flex flex-col">
                            <div class="flex items-center font-medium text-gray-900 dark:text-white">
                                {{ $position->name }}
                            </div>
                            <div class="text-sm/6 text-gray-600 dark:text-gray-400">
                                Position available; apply today &rarr;
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            @if ($column['column'] === 'character-type')
                @if (filled($character))
                    <x-badge :color="$character->type->color()">{{ $character->type->getLabel() }}</x-badge>
                @endif
            @endif

            @if ($column['column'] === 'character-status')
                @if (filled($character))
                    <x-badge :color="$character->status->color()">{{ $character->status->getLabel() }}</x-badge>
                @endif
            @endif
        </div>
    @endforeach
</a>
