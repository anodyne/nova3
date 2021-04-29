<div>
    <x-dropdown trigger-color="blue-soft" trigger-size="xs">
        <x-slot name="trigger">
            <span class="mr-1">Add permission</span>
            <svg class="h-4 w-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 4v16m8-8H4"></path></svg>
        </x-slot>

        <x-dropdown.group class="px-2 py-2">
            <div class="group flex items-center rounded-md bg-gray-100 border-2 border-gray-100 text-gray-600 px-2 py-2 space-x-3 focus-within:border-gray-200 focus-within:bg-white focus-within:text-gray-700">
                @icon('search', 'flex-shrink-0 h-5 w-5 text-gray-400 group-focus-within:text-gray-600')

                <input wire:model.debounce.250ms="search" type="text" placeholder="Find a permission..." class="flex w-full appearance-none bg-transparent border-none p-0 focus:ring-0 focus:outline-none">

                @isset($search)
                    <x-button wire:click="$set('search', null)" color="gray-text" size="none">
                        @icon('close-alt')
                    </x-button>
                @endisset
            </div>
        </x-dropdown.group>

        @if ($results)
            <x-dropdown.group>
                @forelse ($results as $item)
                    <x-dropdown.item type="button" wire:click="addPermission({{ $item['id'] }}, {{ $item }})">
                        {{ $item['display_name'] }}
                    </x-dropdown.item>
                @empty
                    <x-dropdown.text>
                        No results found
                    </x-dropdown.text>
                @endforelse
            </x-dropdown.group>
        @endif
    </x-dropdown>

    @foreach ($permissions as $permission)
        <span class="inline-flex items-center px-2.5 py-1.5 mb-2 uppercase tracking-wide border border-transparent text-xs font-medium rounded-md text-gray-700 bg-gray-100 focus:outline-none focus:border-gray-300 focus:ring active:bg-gray-200 transition ease-in-out duration-150 space-x-2">
            <span>{{ $permission['display_name'] }}</span>
            <x-button wire:click="removePermission({{ $permission['id'] }})" type="button" color="gray-text" size="none">
                <svg class="h-4 w-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 18L18 6M6 6l12 12"></path></svg>
            </x-button>
        </span>
        <input type="hidden" name="permissions[]" value="{{ $permission['id'] }}">
    @endforeach
</div>
