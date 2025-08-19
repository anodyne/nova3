@props([
    'search',
    'placeholder' => 'Search...',
])

<x-spacing size="3xs" class="relative">
    <x-input wire:model.live.debounce="search" :$placeholder clearable>
        <x-slot name="icon">
            <x-icon :name="Tabler::Search" size="sm" />
        </x-slot>
    </x-input>

    @if (filled($search))
        <div
            class="absolute isolate z-10 mt-1.5 max-h-60 min-w-60 overflow-y-scroll rounded-xl bg-gray-950 p-1 shadow-lg ring-1 ring-black focus:outline-hidden"
            role="menu"
            tabindex="-1"
        >
            {{ $slot }}
        </div>
    @endif
</x-spacing>
