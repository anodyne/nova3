@props([
    'title' => false,
    'message' => false,
])

<x-content-box height="none" class="flex flex-col pt-4 md:flex-row md:pt-8" {{ $attributes }}>
    @if ($title || $message)
        <div class="mb-8 w-full md:w-2/5 md:mr-16 md:mb-0">
            @if ($title)
                <h3 class="font-bold text-xl text-gray-600 dark:text-gray-300 tracking-tight">{{ $title }}</h3>
            @endif

            @if ($message)
                <div class="mt-2 space-y-6">{{ $message }}</div>
            @endif
        </div>
    @endif

    <div class="flex-1 space-y-8">
        {{ $slot }}
    </div>
</x-content-box>
