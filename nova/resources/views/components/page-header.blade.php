@props([
    'title',
    'controls' => false,
    'pretitle' => false,
])

<div class="mb-8 px-4 sm:px-0 md:flex md:items-center md:justify-between" data-cy="page-header" {{ $attributes }}>
    <div class="flex-1 min-w-0">
        @if ($pretitle)
            <div class="block mb-2 leading-none text-base md:text-sm text-gray-500 font-semibold uppercase tracking-wide">
                {{ $pretitle }}
            </div>
        @endif

        <x-h1 data-cy="page-header-title">{{ $title ?? $slot }}</x-h1>
    </div>

    @if ($controls)
        <div class="inline-flex flex-row-reverse sm:flex-row items-center w-auto mt-4 md:mt-0 space-x-4 space-x-reverse sm:space-x-4" data-cy="page-header-controls">
            {{ $controls }}
        </div>
    @endif
</div>
