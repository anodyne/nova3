<div class="relative inline-block text-left">
    <div>
        <span class="rounded-md shadow-sm">
            <button
                {{-- x-on:click="open = !open" --}}
                x-on:click="$dispatch('open-dropdown')"
                type="button"
                class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150"
            >
                {{ $slot }}
            </button>
        </span>
    </div>

    <portal :disabled="false">
        <div
            x-data="{ open: false }"
            x-show="open"
            x-description="Dropdown panel, show/hide based on dropdown state."
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            x-on:keydown.window.escape="open = false"
            x-on:click.away="open = false"
            x-on:open-dropdown.window="open = true"
            class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg"
        >
            <div class="rounded-md bg-white shadow-xs">
                <div class="py-1">
                    {{ $dropdown }}
                </div>
            </div>
        </div>
    </portal>
</div>