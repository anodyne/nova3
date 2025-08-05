@props([
    'post',
])

@php
    $showMetaFields = $post->postType->fields->location->enabled || $post->postType->fields->day->enabled || $post->postType->fields->time->enabled;
@endphp

@if ($showMetaFields)
    <div
        {{ $attributes->merge(['class' => 'relative flex flex-col space-y-3 text-base md:text-sm md:flex-row md:items-center md:space-x-8 md:space-y-0']) }}
    >
        @if ($post->postType->fields->location->enabled && filled($post->location))
            <x-metadata :icon="Icon::Location" :value="$post->location"></x-metadata>
        @endif

        @if ($post->postType->fields->day->enabled && filled($post->day))
            <x-metadata :icon="Icon::Calendar" :value="$post->day"></x-metadata>
        @endif

        @if ($post->postType->fields->time->enabled && filled($post->time))
            <x-metadata :icon="Icon::Clock" :value="$post->time"></x-metadata>
        @endif
    </div>
@endif
