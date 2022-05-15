@props(['search', 'placeholder'])

<div x-data="{ search: '{{ $search }}', isLoading: false }">
    <label for="email" class="sr-only">{{ $placeholder }}</label>
    <div class="flex items-center py-1 text-gray-500 transition ease-in-out duration-200 focus-within:text-gray-600">
        @icon('search', 'mr-3 shrink-0')

        <input
            x-model="search"
            @keydown.debounce.150="isLoading = true"
            @keydown.debounce.500="refreshList($event.target.value)"
            autocomplete="off"
            class="relative w-full appearance-none bg-transparent text-gray-600 border-none p-0 focus:ring-0 focus:outline-none"
            name="search"
            type="text"
            value="{{ $search }}"
            placeholder="{{ $placeholder }}"
            data-cy="search-field"
            role="searchbox"
        >

        <x-loader-circle x-show="isLoading" x-cloak class="h-5 w-5 text-gray-500 ml-3" />

        <x-button
            x-show="!!search"
            @click.prevent="isLoading = true; search = ''; refreshList(null);"
            x-cloak
            id="clear-search"
            class="ml-3"
            color="gray-text"
            size="none"
            data-cy="search-clear"
            role="button"
            aria-label="Reset"
        >
            @icon('close', 'h-5 w-5')
        </x-button>
    </div>
</div>

@push('scripts')
    <script>
        function refreshList(query)
        {
            const url = new URL(window.location.href);

            if (query == null) {
                url.searchParams.delete('search');
            } else {
                if (url.searchParams.has('search')) {
                    url.searchParams.set('search', query);
                } else {
                    url.searchParams.append('search', query);
                }
            }

            window.location.replace(url);
        }
    </script>
@endpush
