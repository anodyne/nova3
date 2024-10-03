@props([
    'heading' => null,
    'description' => null,
    'intro' => null,
    'actions' => null,
    'meta' => null,
])

@php
    $heading ??= $meta?->pageHeading;
    $description ??= $meta?->pageSubheading;
    $intro ??= $meta?->pageIntro;
@endphp

@if (filled($heading) || filled($description) || filled($intro))
    <div {{ $attributes->class(['mb-8']) }} data-slot="header" data-cy="page-header">
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <x-h1>{{ $heading ?? $slot }}</x-h1>
            </div>

            @if ($actions?->isNotEmpty())
                <div
                    class="mt-4 inline-flex w-auto flex-row-reverse items-center space-x-4 space-x-reverse sm:flex-row sm:space-x-4 md:mt-0"
                    data-cy="page-header-controls"
                >
                    {{ $actions }}
                </div>
            @endif
        </div>

        @if (filled($description))
            <div class="mt-1.5 w-full max-w-lg text-base text-gray-500 dark:text-gray-400 sm:text-sm/6">
                {{ $description }}
            </div>
        @endif

        @if (filled($intro))
            <div class="mt-6 w-full max-w-2xl text-base/7 text-gray-600 dark:text-gray-400">
                {{ $intro }}
            </div>
        @endif
    </div>
@endif
