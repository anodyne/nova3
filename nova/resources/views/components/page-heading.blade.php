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
    <div {{ $attributes->class(['mb-8']) }} data-slot="header">
        <div class="md:flex md:items-center md:justify-between">
            <div class="min-w-0 flex-1">
                <x-h1>
                    {{ $heading ?? $slot }}
                </x-h1>
            </div>

            @if ($actions?->isNotEmpty())
                <div
                    class="mt-4 inline-flex w-auto flex-row-reverse items-center space-x-4 space-x-reverse sm:flex-row sm:space-x-4 md:mt-0"
                >
                    {{ $actions }}
                </div>
            @endif
        </div>

        @if (filled($description))
            <x-text class="w-full max-w-lg">
                {{ $description }}
            </x-text>
        @endif

        @if (filled($intro))
            <x-text size="lg" class="mt-6 w-full max-w-2xl">
                {{ $intro }}
            </x-text>
        @endif
    </div>
@endif
