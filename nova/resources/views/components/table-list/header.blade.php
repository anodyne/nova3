@props([
    'title',
    'description' => false,
    'controls' => false,
])

<x-content-box height="sm" class="border-b border-gray-200 dark:border-gray-700">
    <div class="flex justify-between">
        <div>
            <x-h2>{{ $title }}</x-h2>

            @if ($description)
                <p class="mt-0.5 text-gray-500 text-sm">{{ $description }}</p>
            @endif
        </div>

        @if ($controls)
            <div class="flex items-center space-x-4">
                {{ $controls }}
            </div>
        @endif
    </div>
</x-content-box>
