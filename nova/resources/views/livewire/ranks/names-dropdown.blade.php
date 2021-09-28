<div
    x-data="listBox({ value: {{ $selectedId ?? 0 }}, selected: {{ $selectedId ?? 0 }} })"
    @listbox-close.window="open = false"
    class="relative w-full"
>
    <input type="hidden" name="name_id" value="{{ $selectedId }}">

    <span class="relative flex w-full rounded-md shadow-sm">
        <button
            x-ref="button"
            @keydown.arrow-up.stop.prevent="onButtonClick()"
            @keydown.arrow-down.stop.prevent="onButtonClick()"
            @click="onButtonClick()"
            type="button"
            aria-haspopup="listbox"
            :aria-expanded="open"
            aria-labelledby="listbox-label"
            class="cursor-default relative w-full rounded-md border border-gray-6 bg-gray-1 pl-3 pr-10 py-2 text-left focus:outline-none focus:ring focus:border-blue-7 transition ease-in-out duration-150"
        >
            <span class="block truncate">
                {{ optional($selected)->name ?? 'Select a rank name' }}
            </span>
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                <svg class="h-5 w-5 text-gray-9" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                    <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </span>
        </button>
    </span>

    <div
        x-show="open"
        @click.away="open = false"
        x-description="Select popover, show/hide based on select state."
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute mt-1 w-full rounded-md bg-gray-1 shadow-lg z-10"
        style="display: none;"
    >
        <ul
            @keydown.enter.stop.prevent="onOptionSelect()"
            @keydown.escape="onEscape()"
            @keydown.arrow-up.prevent="onArrowUp()"
            @keydown.arrow-down.prevent="onArrowDown()"
            x-ref="listbox"
            tabindex="-1"
            role="listbox"
            aria-labelledby="listbox-label"
            :aria-activedescendant="activeDescendant"
            class="max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none | sm:text-sm"
            aria-activedescendant="listbox-option-0"
        >
            <li class="p-2">
                <div class="group flex items-center rounded-md bg-gray-100 border-2 border-gray-100 text-gray-600 px-2 py-2 space-x-3 focus-within:border-gray-6 focus-within:bg-gray-1 focus-within:text-gray-700">
                    @icon('search', 'flex-shrink-0 h-5 w-5 text-gray-400 group-focus-within:text-gray-600')

                    <input wire:model.debounce.250ms="search" type="text" placeholder="Find a rank name..." class="flex w-full appearance-none bg-transparent border-none p-0 focus:ring-0 focus:outline-none">

                    @isset($search)
                        <x-button wire:click="$set('search', null)" color="gray-text" size="none">
                            @icon('close-alt')
                        </x-button>
                    @endisset
                </div>
            </li>

            @forelse ($names as $name)
                <li
                    x-description="Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation."
                    x-state:on="Highlighted"
                    x-state:off="Not Highlighted"
                    id="listbox-option-{{ $name->id }}"
                    role="option"
                    wire:click="selectName({{ $name->id }})"
                    @mouseenter="selected = {{ $name->id }}"
                    @mouseleave="selected = null"
                    :class="{ 'text-white bg-blue-9': selected === {{ $name->id }}, 'text-gray-900': !(selected === {{ $name->id }}) }"
                    class="cursor-default select-none relative py-2 pl-3 pr-9 text-gray-900"
                >
                    <span
                        x-state:on="Selected"
                        x-state:off="Not Selected"
                        :class="{ 'font-semibold': value === {{ $name->id }}, 'font-normal': !(value === {{ $name->id }}) }"
                        class="block truncate font-semibold"
                    >
                        {{ $name->name }}
                    </span>

                    @if ($selectedId === $name->id)
                        <span
                            x-description="Checkmark, only display for selected option."
                            x-state:on="Highlighted"
                            x-state:off="Not Highlighted"
                            :class="{ 'text-white': selected === {{ $name->id }}, 'text-blue-9': !(selected === {{ $name->id }}) }"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-blue-9"
                        >
                            @icon('check', 'h-5 w-5')
                        </span>
                    @endif
                </li>
            @empty
                <li class="py-4">
                    <div class="text-center">
                        <div class="text-gray-500">There is no rank name named</div>
                        <div class="text-gray-800 font-medium mt-1 mb-6">&lsquo;{{ $search }}&rsquo;</div>

                        <x-button wire:click="createAndSelectName" type="button" color="blue">
                            Create this name
                        </x-button>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>
</div>
