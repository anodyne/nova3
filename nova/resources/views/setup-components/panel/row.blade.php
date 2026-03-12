@props([
    'icon' => false,
    'heading',
    'leading' => false,
    'trailing' => false,
])

<x-spacing class="col-span-3 grid grid-cols-subgrid" size="sm" {{ $attributes }}>
    @if ($icon)
        <div class="mr-4 shrink-0">
            <x-icon :name="$icon" class="text-gray-500" size="lg" />
        </div>
    @endif

    @if ($leading)
        <div class="mr-4 shrink-0">
            {{ $leading }}
        </div>
    @endif

    <div @class([
        'col-start-2' => $icon || $leading,
    ])>
        <x-heading size="lg" level="2" class="leading-7">{{ $heading }}</x-heading>

        @unless ($slot->isEmpty())
            <div class="mt-2 space-y-4 text-sm/6 font-normal text-gray-500">
                {{ $slot }}
            </div>
        @endunless
    </div>

    @if ($trailing)
        <div class="col-start-3 ml-4 flex shrink-0 justify-end">
            {{ $trailing }}
        </div>
    @endif
</x-spacing>
