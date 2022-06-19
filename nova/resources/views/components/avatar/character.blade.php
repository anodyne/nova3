@props([
    'character',
    'primaryRank' => true,
    'primaryStatus' => false,
    'secondaryPositions' => true,
    'secondaryStatus' => false,
    'secondaryType' => false,
])

<x-avatar.meta :src="$character->avatar_url" {{ $attributes }}>
    <x-slot:primary>
        @if ($primaryStatus)
            <div class="flex items-center mr-2">
                <x-status :status="$character->status"></x-status>
            </div>
        @endif

        @if ($primaryRank)
            {{ $character?->rank?->name?->name }}
        @endif

        {{ $character->name }}
    </x-slot:primary>

    @if ($secondaryPositions || $secondaryStatus || $secondaryType)
        <x-slot:secondary>
            @if ($secondaryPositions)
                {{ $character?->positions->implode('name', ' & ') }}
            @endif

            @if ($secondaryStatus)
                <x-badge :color="$character->status->color()" size="xs">{{ $character->status->displayName() }}</x-badge>
            @endif

            @if ($secondaryType)
                <x-badge :color="$character->type->color()" size="xs">{{ $character->type->displayName() }}</x-badge>
            @endif
        </x-slot:secondary>
    @endif
</x-avatar.meta>
