@props([
    'post',
    'leading' => false,
    'trailing' => false,
])

@php
    $showMetaFields = $post->postType->fields->location->enabled || $post->postType->fields->day->enabled || $post->postType->fields->time->enabled;
@endphp

@if ($showMetaFields || $leading || $trailing)
    <x-metadata.group gap="lg" {{ $attributes }}>
        @if ($leading)
            {{ $leading }}
        @endif

        @if ($post->postType->fields->location->enabled && filled($post->location))
            <x-metadata :icon="Tabler::MapPin" :value="$post->location"></x-metadata>
        @endif

        @if ($post->postType->fields->day->enabled && filled($post->day))
            <x-metadata :icon="Tabler::Calendar" :value="$post->day"></x-metadata>
        @endif

        @if ($post->postType->fields->time->enabled && filled($post->time))
            <x-metadata :icon="Tabler::Clock" :value="$post->time"></x-metadata>
        @endif

        @if ($trailing)
            {{ $trailing }}
        @endif
    </x-metadata.group>
@endif
