@props([
    'footer' => null,
    'icon' => null,
    'title',
])

<x-panel variant="well" class="flex h-full flex-col">
    <x-panel.header :title="$title" :icon="$icon" icon-size="md">
        <x-slot name="actions">
            <button
                x-on:click="Livewire.dispatch('slide-over.close')"
                alt="Close modal"
                class="relative inline-flex h-8 w-8 items-center justify-center gap-2 whitespace-nowrap rounded-md bg-transparent text-sm font-medium text-gray-400 transition hover:bg-gray-800/5 hover:text-gray-800 dark:text-gray-500 dark:hover:bg-white/15 dark:hover:text-white"
            >
                <x-icon name="x" size="sm"></x-icon>
            </button>
        </x-slot>
    </x-panel.header>

    <x-panel class="flex-1">
        <x-spacing size="md">
            {{ $slot }}
        </x-spacing>
    </x-panel>

    @if ($footer)
        <x-panel.footer class="flex items-center gap-x-4">
            {{ $footer }}
        </x-panel.footer>
    @endif
</x-panel>
