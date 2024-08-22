@props([
    'character' => null,
    'position' => null,
    'options' => [],
])

<a class="flex items-center rounded-lg px-4 py-2 hover:bg-gray-50 dark:hover:bg-gray-900" {{ $attributes }}>
    <div
        @class([
            'inline-flex gap-x-3',
            'items-center' => ! in_array('position', $options) && ! in_array('type', $options) && ! in_array('status', $options) && ! in_array('rank-image', $options),
        ])
    >
        @if (filled($character?->avatar_url) && in_array('avatar', $options))
            <x-avatar :src="$character->avatar_url" size="lg"></x-avatar>
        @endif

        <div class="flex flex-col">
            <div class="flex items-center text-lg/7 font-medium text-gray-900 dark:text-white">
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
                <div class="mt-1">
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
    </div>
</a>
