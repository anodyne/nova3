<div
    x-data="{ open: false }"
    @keydown.window.escape="open = false"
    @click.away="open = false"
    @dropdown-toggle="open = !open"
    @dropdown-close.window="open = false"
    class="relative inline-block text-left leading-0"
>
    <div>
        @isset ($trigger)
            <x-button.text
                tag="button"
                @click="open = !open"
                :color="$trigger->attributes->get('color', 'gray')"
                :leading="$trigger->attributes->get('leading')"
                :trailing="$trigger->attributes->get('trailing')"
                aria-haspopup="true"
                aria-expanded="true"
                x-bind:aria-expanded="open"
            >
                {{ $trigger }}
            </x-button.text>
        @endisset

        @isset ($emptyTrigger)
            <div
                role="button"
                @click="open = !open"
                aria-haspopup="true"
                aria-expanded="true"
                x-bind:aria-expanded="open"
            >
                {{ $emptyTrigger }}
            </div>
        @endisset
    </div>

    <div
        x-show="open"
        x-description="Dropdown panel, show/hide based on dropdown state."
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute mt-2 rounded-lg shadow-lg z-[9999] {{ $placementStyles() }} {{ $wide ? 'w-72' : 'w-56'}} {{ $maxHeight ?: '' }}"
        x-cloak
    >
        <div class="rounded-lg bg-white dark:bg-gray-700 ring-1 ring-gray-900/5 dark:ring-gray-800 z-10 divide-y divide-gray-200 dark:divide-gray-600/50 dark:highlight-white/10">
            {{ $slot }}
        </div>
    </div>
</div>
