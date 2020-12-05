<div
    x-data="{ open: false }"
    x-on:keydown.window.escape="open = false"
    x-on:click.away="open = false"
    x-on:dropdown-toggle="open = !open"
    x-on:dropdown-close.window="open = false"
    class="relative inline-block text-left leading-0"
>
    <div>
        <x-button
            x-on:click="open = !open"
            type="button"
            :color="$triggerColor"
            :size="$triggerSize"
            id="{{ $id }}"
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
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute mt-2 rounded-md shadow-lg z-9999 {{ $placementStyles() }} @if ($wide) w-72 @else w-56 @endif"
        x-cloak
    >
        <div class="rounded-md bg-white ring-1 ring-black ring-opacity-5 z-10">
            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="{{ $id }}">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
