@props([
    'icon' => null,
    'title',
])

{{-- format-ignore-start --}}
<x-spacing size="md">
    <div class="flex flex-col gap-6">
        <div class="flex justify-between">
            <div class="flex items-center gap-3">
                @if (filled($icon))
                    <x-icon :name="$icon" size="lg" class="text-gray-500"></x-icon>
                @endif
                <x-h2>{{ $title }}</x-h2>
            </div>

            <x-button color="neutral" wire:click="dismiss" text>
                <x-icon name="x" size="sm"></x-icon>
            </x-button>
        </div>
        <div class="flex flex-col gap-4">
            {{ $slot }}
        </div>
    </div>
</x-spacing>
{{-- format-ignore-end --}}
