@props([
    'heading',
    'description' => null,
    'actions' => null,
])

<div
    @class([
        'mb-8 px-4 sm:px-0',
        $attributes->get('class') => $attributes->has('class'),
    ])
    data-slot="header"
    data-cy="page-header"
    {{ $attributes }}
>
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

    @if ($description?->isNotEmpty())
        <div class="mt-1.5 w-full max-w-lg text-base text-gray-500 sm:text-sm/6 dark:text-gray-400">
            {{ $description }}
        </div>
    @endif
</div>
