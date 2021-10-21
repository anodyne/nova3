@props([
    'title',
    'controls' => false,
    'pretitle' => false,
])

<div class="mb-8 px-4 sm:px-0 sm:flex sm:items-center sm:justify-between" data-cy="page-header">
    <div class="flex-1 min-w-0">
        @if ($pretitle)
            <div class="block mb-2 leading-none text-sm text-gray-9 font-semibold uppercase tracking-wide">
                {{ $pretitle }}
            </div>
        @endif

        <h1 class="block text-3xl font-extrabold text-gray-12 tracking-tight sm:truncate" data-cy="page-header-title">
            {{ $title ?? $slot }}
        </h1>
    </div>

    @if ($controls)
        <div class="inline-flex flex-row-reverse items-center w-auto mt-4 space-x-4 space-x-reverse sm:mt-0 sm:flex-row sm:space-x-4" data-cy="page-header-controls">
            {{ $controls }}
        </div>
    @endif
</div>
