@props([
    'icon',
    'heading',
])

<div data-slot="heading" {{ $attributes->class(['grid grid-cols-[1.5rem_1fr] gap-2.5']) }}>
    <div class="col-start-1 row-start-1 text-gray-500">
        @if ($icon instanceof BackedEnum)
            <x-icon :name="$icon" size="md" />
        @else
            {{ $icon }}
        @endif
    </div>

    <div class="col-start-2 row-start-1">
        <x-heading size="lg" level="3" class="leading-6">{{ $heading }}</x-heading>

        <div class="space-y-4">
            {{ $slot }}
        </div>
    </div>
</div>
