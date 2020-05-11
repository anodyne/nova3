@props(['dropdown'])

<div
    x-data="{ id: 1 }"
    x-on:close-dropdown.window="$event.detail.id == id && $el.remove()"
    class="relative inline-block text-left"
>
    <div>
        <span class="rounded-md shadow-sm">
            <button
                x-on:click="$dispatch('open-dropdown', { id })"
                type="button"
                class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150"
            >
                {{ $slot }}
            </button>
        </span>
    </div>
</div>

@push('dropdown')
    <div
        x-data="{ open: false, id: 0 }"
        x-on:open-dropdown.window="open = true; id = $event.detail.id"
        x-on:click.away="open = false"
        x-on:keydown.window.escape="open = false"
        x-show="open"
        x-description="Dropdown panel, show/hide based on dropdown state."
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="origin-top-right absolute top-0 right-0 mt-2 w-56 rounded-md shadow-lg"
    >
        <div class="rounded-md bg-white shadow-xs">
            <div class="py-1">
                {{ $dropdown }}
            </div>
        </div>
    </div>
@endpush
