@props([
    'title' => false,
    'message' => false,
])

<x-spacing height="lg" class="flex flex-col md:flex-row" {{ $attributes }}>
    @if ($title || $message)
        <div class="mb-8 w-full md:mb-0 md:mr-16 md:w-2/5">
            @if ($title)
                <x-h3>{{ $title }}</x-h3>
            @endif

            @if ($message)
                <div class="mt-2 space-y-6">{{ $message }}</div>
            @endif
        </div>
    @endif

    <div class="flex-1 space-y-8">
        {{ $slot }}
    </div>
</x-spacing>
