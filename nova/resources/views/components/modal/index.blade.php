@props([
    'footer' => null,
    'icon' => null,
    'description' => null,
    'title',
])

<x-panel variant="well" class="flex h-full flex-col" {{ $attributes }}>
    <x-panel class="flex-1">
        <x-spacing size="md">
            <div class="flex flex-col gap-6">
                <div class="flex justify-between gap-6">
                    <div class="flex items-center gap-3">
                        @if ($icon)
                            <x-icon :name="$icon" size="lg" class="text-gray-500"></x-icon>
                        @endif

                        <x-h2>{{ $title }}</x-h2>
                    </div>

                    <div class="shrink-0">
                        <button
                            x-on:click="Livewire.dispatch('modal.close')"
                            alt="Close modal"
                            class="relative inline-flex h-8 w-8 items-center justify-center gap-2 whitespace-nowrap rounded-md bg-transparent text-sm font-medium text-gray-400 transition hover:bg-gray-800/5 hover:text-gray-800 dark:text-gray-500 dark:hover:bg-white/15 dark:hover:text-white"
                        >
                            <x-icon name="x" size="sm"></x-icon>
                        </button>
                    </div>
                </div>

                @if ($description)
                    <div class="text-base/7">{{ $description }}</div>
                @endif

                <div class="flex flex-col gap-6">
                    {{ $slot }}
                </div>
            </div>
        </x-spacing>
    </x-panel>

    @if ($footer)
        <x-panel.footer class="flex items-center gap-x-4">
            {{ $footer }}
        </x-panel.footer>
    @endif
</x-panel>
