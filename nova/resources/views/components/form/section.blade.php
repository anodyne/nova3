@props([
    'title' => false,
    'message' => false,
])

<x-content-box height="lg" class="flex flex-col md:flex-row" {{ $attributes }}>
    @if ($title || $message)
        <div class="mb-8 w-full md:w-2/5 md:mr-16 md:mb-0">
            @if ($title)
                <x-h3>{{ $title }}</x-h3>
            @endif

            @if ($message)
                <div class="mt-2 space-y-6 text-gray-600 dark:text-gray-400">{{ $message }}</div>
            @endif
        </div>
    @endif

    <div class="flex-1 space-y-8">
        {{ $slot }}
    </div>
</x-content-box>
