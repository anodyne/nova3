@props([
    'character',
    'rank' => true,
    'status' => false,
    'positions' => false,
    'type' => false,
    'subtitle' => false,
])

@php
    $character->loadMissing('rank', 'positions');

    $statusColor = ucfirst($character->status->getColor());

    $badgeColor = strtolower(settings("appearance.colors{$statusColor}"));
@endphp

<x-avatar :src="$character->avatar_url" {{ $attributes }} :badge="$status" badge:color="{{ $badgeColor }}">
    <x-slot name="title" class="truncate">
        @if ($rank)
            {{ $character?->rank?->name?->name }}
        @endif

        {{ $character->name }}
    </x-slot>

    @if ($positions || $status || $type || $subtitle)
        <x-slot name="subtitle" class="flex items-center gap-2 truncate">
            @if ($status)
                <x-badge :color="$character->status->getColor()" size="sm">
                    {{ $character->status->getLabel() }}
                </x-badge>
            @endif

            @if ($type)
                <x-badge :color="$character->type->getColor()">
                    {{ $character->type->getLabel() }}
                </x-badge>
            @endif

            @if ($positions)
                {{ $character?->positions->implode('name', ' & ') }}
            @endif

            {{ $subtitle }}
        </x-slot>
    @endif
</x-avatar>
