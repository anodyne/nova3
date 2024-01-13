@props([
    'character',
    'primaryRank' => true,
    'primaryStatus' => false,
    'secondaryPositions' => true,
    'secondaryStatus' => false,
    'secondaryType' => false,
    'secondary' => false,
])

@php($character->loadMissing('rank', 'positions'))

<x-avatar.meta :src="$character->avatar_url" {{ $attributes }}>
    <x-slot name="primary">
        @if ($primaryStatus)
            <div class="mr-2 flex items-center">
                <x-status :status="$character->status"></x-status>
            </div>
        @endif

        @if ($primaryRank)
            {{ $character?->rank?->name?->name }}
        @endif

        {{ $character->name }}
    </x-slot>

    @if ($secondaryPositions || $secondaryStatus || $secondaryType || $secondary)
        <x-slot name="secondary">
            @if ($secondaryPositions)
                {{ $character?->positions->implode('name', ' & ') }}
            @endif

            @if ($secondaryStatus)
                <x-badge :color="$character->status->color()">{{ $character->status->getLabel() }}</x-badge>
            @endif

            @if ($secondaryType)
                <x-badge :color="$character->type->color()">{{ $character->type->getLabel() }}</x-badge>
            @endif

            {{ $secondary }}
        </x-slot>
    @endif
</x-avatar.meta>
