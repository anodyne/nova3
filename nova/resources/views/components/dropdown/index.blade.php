<div
    x-data="{ open: false }"
    @keydown.window.escape="open = false"
    @click.away="open = false"
    @dropdown-toggle="open = !open"
    @dropdown-close.window="open = false"
    class="relative inline-block text-left leading-0"
>
    <div>
        <x-button
            @click="open = !open"
            type="button"
            :color="$triggerColor"
            :size="$triggerSize"
            aria-haspopup="true"
            aria-expanded="true"
            x-bind:aria-expanded="open"
        >
            {{ $trigger }}
        </x-button>
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
        class="absolute mt-2 rounded-md shadow-lg z-[9999] {{ $placementStyles() }} {{ $wide ? 'w-72' : 'w-56'}}"
        x-cloak
    >
        <div class="rounded-lg bg-gray-1 ring-1 ring-gray-12 ring-opacity-5 z-10 divide-y divide-gray-3">
            {{ $slot }}
        </div>
    </div>
</div>
