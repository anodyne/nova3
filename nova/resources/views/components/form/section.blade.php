@props([
    'title' => false,
    'message' => false,
])

<div class="flex flex-col px-4 pt-4 | md:flex-row md:px-8 md:pt-8" {{ $attributes }}>
    @if ($title || $message)
        <div class="mb-8 w-full | md:w-2/5 md:mr-16 md:mb-0">
            @if ($title)
                <h3 class="font-semibold text-xl text-gray-700 tracking-tight">{{ $title }}</h3>
            @endif

            @if ($message)
                <div class="mt-2 text-gray-600 space-y-6">{{ $message }}</div>
            @endif
        </div>
    @endif

    <div class="flex-1 space-y-8">
        {{ $slot }}
    </div>
</div>
