@props([
    'position' => 'center',
    'sizeClass' => 'max-w-lg',
])

<x-livewire-modal::stack class="backdrop-blur-xs">
    <x-livewire-modal::modal :position="$position" class="{{ $sizeClass }} max-h-full w-full overflow-auto shadow-xl">
        <div {{ $attributes }}>
            {{ $slot }}
        </div>
    </x-livewire-modal::modal>
</x-livewire-modal::stack>
