@props([
    'user',
    'status' => false,
    'pronouns' => false,
    'subtitle' => false,
])

@php
    $badgeColor = settings('appearance')->getColorFromSemanticColor($user->status->getColor());
@endphp

<x-avatar
    :src="$user->avatar_url"
    :title="$user->name"
    :badge="$status"
    badge:color="{{ $badgeColor }}"
    {{ $attributes }}
>
    @if ($status || $pronouns || $subtitle)
        <x-slot name="subtitle" class="flex items-center gap-2 truncate">
            @if ($status)
                <x-badge :color="$user->status->getColor()">
                    {{ $user->status->getLabel() }}
                </x-badge>
            @endif

            @if ($pronouns)
                {{ $user->pronouns }}
            @endif

            {{ $subtitle }}
        </x-slot>
    @endif
</x-avatar>
