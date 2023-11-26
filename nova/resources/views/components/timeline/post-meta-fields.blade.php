@props([
    'post',
])

@php
    $showMetaFields = $post->postType->fields->location->enabled || $post->postType->fields->day->enabled || $post->postType->fields->time->enabled;
@endphp

@if ($showMetaFields)
    <div {{ $attributes->merge(['class' => 'relative flex flex-col space-y-3 text-base md:flex-row md:items-center md:space-x-8 md:space-y-0']) }}>
        @if ($post->postType->fields->location->enabled && filled($post->location))
            <div
                class="flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-gray-400"
            >
                <div class="text-gray-400 dark:text-gray-500">
                    <x-icon name="location" size="sm"></x-icon>
                </div>
                <div>{{ $post->location }}</div>
            </div>
        @endif

        @if ($post->postType->fields->day->enabled && filled($post->day))
            <div
                class="flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-gray-400"
            >
                <div class="text-gray-400 dark:text-gray-500">
                    <x-icon name="calendar" size="sm"></x-icon>
                </div>
                <div>{{ $post->day }}</div>
            </div>
        @endif

        @if ($post->postType->fields->time->enabled && filled($post->time))
            <div
                class="flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-gray-400"
            >
                <div class="text-gray-400 dark:text-gray-500">
                    <x-icon name="clock" size="sm"></x-icon>
                </div>
                <div>{{ $post->time }}</div>
            </div>
        @endif
    </div>
@endif