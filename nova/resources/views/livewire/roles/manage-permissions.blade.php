<div>
    <x-dropdown class="inline-flex items-center px-4 py-2 rounded-md font-medium leading-5 bg-blue-50 border border-blue-200 text-blue-800 transition ease-in-out duration-150 hover:bg-blue-100 | md:px-2.5 md:py-0.5 md:text-sm">
        <x-slot name="trigger">
            <span class="mr-1">Add permission</span>
            <svg class="h-5 w-5 text-blue-700 | md:h-4 md:w-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 4v16m8-8H4"></path></svg>
        </x-slot>

        <div class="p-2">
            <div class="flex items-center rounded bg-gray-100 border-2 border-gray-100 text-gray-600 px-2 py-2 focus-within:border-gray-200 focus-within:bg-white focus-within:text-gray-700">
                <div class="flex-shrink-0 mr-3">
                    @icon('search', 'h-5 w-5')
                </div>
                <input wire:model.debounce.250ms="query" type="text" placeholder="Find a permission..." class="block w-full appearance-none bg-transparent focus:outline-none">
            </div>
        </div>

        @if ($results)
            <div class="{{ $component->divider() }}"></div>

            @forelse ($results as $item)
                <button
                    wire:click="addPermission({{ $item['id'] }}, {{ $item }})"
                    type="button"
                    class="{{ $component->link() }}"
                >
                    {{ $item['display_name'] }}
                </button>
            @empty
                <div class="{{ $component->text() }}">
                    No results found
                </div>
            @endforelse
        @endif
    </x-dropdown>

    @foreach ($permissions as $permission)
        <span class="inline-flex items-center mb-2 px-4 py-2 rounded-md font-medium leading-5 bg-gray-50 border border-gray-200 text-gray-800 transition ease-in-out duration-150 hover:bg-gray-100 | md:px-2.5 md:py-0.5 md:text-sm">
            {{ $permission['display_name'] }}
            <button wire:click="removePermission({{ $permission['id'] }})" type="button" class="ml-1 text-gray-400 hover:text-gray-600 focus:outline-none transition ease-in-out duration-150">
                <svg class="h-5 w-5 | md:h-4 md:w-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </span>
        <input type="hidden" name="permissions[]" value="{{ $permission['id'] }}">
    @endforeach
</div>
