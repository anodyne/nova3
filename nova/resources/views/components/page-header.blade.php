@props(['title'])

<div class="mb-8 | sm:flex sm:items-center sm:justify-between" data-cy="page-header">
    <div class="flex-1 min-w-0">
        @if (isset($pretitle))
            <div class="block mb-2 leading-none text-sm text-gray-600 dark:text-gray-500 font-semibold uppercase tracking-wide">
                {{ $pretitle }}
            </div>
        @endif

        <h1 class="block text-2xl font-extrabold leading-7 text-gray-900 dark:text-gray-100 | sm:text-3xl sm:leading-9 sm:truncate" data-cy="page-header-title">
            {{ $title ?? $slot }}
        </h1>
    </div>

    @if (isset($controls))
        <div class="inline-flex flex-row-reverse items-center w-auto mt-4 | sm:mt-0 sm:flex-row" data-cy="page-header-controls">
            {{ $controls }}
        </div>
    @endif
</div>
