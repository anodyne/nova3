<div>
    <x-dropdown class="inline-flex items-center px-4 py-2 rounded-md font-medium bg-blue-50 border border-blue-200 text-blue-800 transition ease-in-out duration-150 hover:bg-blue-100 | md:px-2.5 md:py-0.5 md:text-sm">
        <x-slot name="trigger">
            <span class="mr-1">Add role</span>
            <svg class="h-5 w-5 text-blue-700 | md:h-4 md:w-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 4v16m8-8H4"></path></svg>
        </x-slot>

        <div class="p-2">
            <div class="group flex items-center rounded-md bg-gray-100 border-2 border-gray-100 text-gray-600 px-2 py-2 space-x-3 focus-within:border-gray-200 focus-within:bg-white focus-within:text-gray-700">
                @icon('search', 'flex-shrink-0 h-5 w-5 text-gray-400 group-focus-within:text-gray-600')

                <input wire:model.debounce.250ms="search" type="text" placeholder="Find a role..." class="flex w-full appearance-none bg-transparent focus:outline-none">

                @isset($search)
                    <x-button wire:click="$set('search', null)" color="gray-text" size="none">
                        @icon('close-alt')
                    </x-button>
                @endisset
            </div>
        </div>

        @isset ($results)
            <div class="{{ $component->divider() }}"></div>

            @forelse ($results as $item)
                <button
                    wire:click="addRole({{ $item['id'] }}, {{ $item }})"
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
        @endisset
    </x-dropdown>

    @foreach ($roles as $role)
        <span class="inline-flex items-center mb-2 px-4 py-2 rounded-md font-medium bg-gray-50 border border-gray-200 text-gray-800 transition ease-in-out duration-150 hover:bg-gray-100 | md:px-2.5 md:py-0.5 md:text-sm">
            {{ $role['display_name'] }}
            <button wire:click="removeRole({{ $role['id'] }})" type="button" class="ml-1 text-gray-400 hover:text-gray-600 focus:outline-none transition ease-in-out duration-150">
                <svg class="h-5 w-5 | md:h-4 md:w-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </span>
        <input type="hidden" name="roles[]" value="{{ $role['id'] }}">
    @endforeach
</div>
