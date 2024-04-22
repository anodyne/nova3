@props([
    'heading' => null,
    'description' => null,
    'controls' => null,
])

<x-spacing width="sm" top="sm" bottom="xs">
    <div class="flex items-center justify-between">
        <div>
            @if (filled($heading))
                <x-fieldset.legend>{{ $heading }}</x-fieldset.legend>
            @endif

            @if (filled($description))
                <x-fieldset.description>{{ $description }}</x-fieldset.description>
            @endif
        </div>

        @if ($controls?->isNotEmpty())
            {{ $controls }}
        @endif
    </div>
</x-spacing>
