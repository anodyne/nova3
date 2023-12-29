@props(['search', 'placeholder'])

<div x-data="{ search: '{{ $search }}', isLoading: false }">
    <label for="email" class="sr-only">{{ $placeholder }}</label>
    <div class="flex items-center py-1 text-gray-500 transition duration-200 ease-in-out focus-within:text-gray-600">
        <x-icon name="search" size="sm" class="mr-3 shrink-0"></x-icon>

        <input
            x-model="search"
            x-on:keydown.debounce.150="isLoading = true"
            x-on:keydown.debounce.500="refreshList($event.target.value)"
            autocomplete="off"
            class="relative w-full appearance-none border-none bg-transparent p-0 text-gray-600 focus:outline-none focus:ring-0"
            name="search"
            type="text"
            value="{{ $search }}"
            placeholder="{{ $placeholder }}"
            data-cy="search-field"
            role="searchbox"
        />

        <x-loader-circle x-show="isLoading" x-cloak class="ml-3 size-5 text-gray-500" />

        <x-button
            x-show="!!search"
            x-on:click.prevent="isLoading = true; search = ''; refreshList(null);"
            x-cloak
            id="clear-search"
            class="ml-3"
            color="neutral"
            data-cy="search-clear"
            role="button"
            aria-label="Reset"
            text
        >
            <x-icon name="x" size="sm"></x-icon>
        </x-button>
    </div>
</div>

@push('scripts')
    <script>
        function refreshList(query) {
            const url = new URL(window.location.href);

            if (query == null) {
                url.searchParams.delete("search");
            } else {
                if (url.searchParams.has("search")) {
                    url.searchParams.set("search", query);
                } else {
                    url.searchParams.append("search", query);
                }
            }

            window.location.replace(url);
        }
    </script>
@endpush
