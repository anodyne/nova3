@props([
    'title',
    'description' => false,
    'controls' => false,
])

<x-content-box height="sm" class="border-b border-gray-200 dark:border-gray-200/10">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 md:space-x-6">
        <div>
            <x-h2>{{ $title }}</x-h2>

            @if ($description)
                <p class="mt-0.5 text-gray-500 text-sm leading-5">{{ $description }}</p>
            @endif
        </div>

        @if ($controls)
            <div class="shrink-0 flex items-center space-x-reverse space-x-6 md:space-x-6">
                {{ $controls }}
            </div>
        @endif
    </div>
</x-content-box>
