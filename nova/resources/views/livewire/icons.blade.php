<div
    x-data="AlpineComponents.listBox({ value: '{{ $selected }}', selected: '{{ $selected }}' })"
    x-init="init()"
    x-on:listbox-close.window="open = false"
    class="relative w-full"
>
    <input type="hidden" name="icon" value="{{ $selected }}">

    <span class="inline-block w-full rounded-md shadow-sm">
        <button
            x-ref="button"
            x-on:keydown.arrow-up.stop.prevent="onButtonClick()"
            x-on:keydown.arrow-down.stop.prevent="onButtonClick()"
            x-on:click="onButtonClick()"
            type="button"
            aria-haspopup="listbox"
            x-bind:aria-expanded="open"
            aria-labelledby="listbox-label"
            class="cursor-default relative w-full rounded-md border border-gray-200 bg-white pl-3 pr-10 py-2 text-left focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition ease-in-out duration-150"
        >
            <span class="flex items-center space-x-2 truncate">
                @isset($selected)
                    @icon($selected, 'h-6 w-6')
                    <span>{{ $selected }}</span>
                @else
                    Select an icon
                @endisset
            </span>
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                <svg class="h-6 w-6 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                    <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </span>
        </button>
    </span>

    <div
        x-show="open"
        x-on:click.away="open = false"
        x-description="Select popover, show/hide based on select state."
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute mt-2 w-full rounded-md bg-white shadow-lg z-10"
        style="display: none;"
    >
        <div
            x-on:keydown.enter.stop.prevent="onOptionSelect()"
            x-on:keydown.escape="onEscape()"
            x-on:keydown.arrow-up.prevent="onArrowUp()"
            x-on:keydown.arrow-down.prevent="onArrowDown()"
            x-ref="listbox"
            tabindex="-1"
            role="listbox"
            aria-labelledby="listbox-label"
            x-bind:aria-activedescendant="activeDescendant"
            class="max-h-60 rounded-md py-1 text-base shadow-xs overflow-auto focus:outline-none | sm:text-sm"
            aria-activedescendant="listbox-option-0"
        >
            <div class="p-2">
                <div class="group flex items-center rounded-md bg-gray-100 border-2 border-gray-100 text-gray-600 px-2 py-2 space-x-3 focus-within:border-gray-200 focus-within:bg-white focus-within:text-gray-700">
                    @icon('search', 'h-5 w-5 flex-shrink-0 text-gray-400 group-focus-within:text-gray-600')

                    <input wire:model.debounce.250ms="search" type="text" placeholder="Find an icon..." class="flex w-full appearance-none bg-transparent focus:outline-none">

                    @isset($search)
                        <x-button wire:click="$set('search', null)" color="gray-text" size="none">
                            @icon('close-alt')
                        </x-button>
                    @endisset
                </div>
            </div>

            @if (count($icons) === 0)
                <div class="py-4">
                    <div class="text-center">
                        <div class="text-gray-500">No icons found with the name</div>
                        <div class="text-gray-800 font-medium mt-1">&lsquo;{{ $search }}&rsquo;</div>
                    </div>
                </div>
            @else
                <div class="flex flex-wrap mx-3">
                    <div
                        x-description="Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation."
                        x-state:on="Highlighted"
                        x-state:off="Not Highlighted"
                        id="listbox-option-0"
                        role="option"
                        wire:click="selectIcon('')"
                        x-on:mouseenter="selected = ''"
                        x-on:mouseleave="selected = null"
                        x-bind:class="{ 'text-white bg-blue-600': selected === '', 'text-gray-900': !(selected === '') }"
                        class="flex-shrink-0 cursor-pointer select-none relative p-2 text-gray-900 flex items-center justify-center rounded"
                    >
                        <div
                            x-state:on="Selected"
                            x-state:off="Not Selected"
                            x-bind:class="{ 'font-semibold': value === '', 'font-normal': !(value === '') }"
                            class="flex flex-col items-center truncate w-8 h-8 text-xs leading-tight"
                        >
                            No<br>icon
                        </div>
                    </div>

                    @foreach ($icons as $icon => $value)
                        <div
                            x-description="Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation."
                            x-state:on="Highlighted"
                            x-state:off="Not Highlighted"
                            id="listbox-option-{{ $icon }}"
                            role="option"
                            wire:click="selectIcon('{{ $icon }}')"
                            x-on:mouseenter="selected = '{{ $icon }}'"
                            x-on:mouseleave="selected = null"
                            x-bind:class="{ 'text-white bg-blue-600': selected === '{{ $icon }}', 'text-gray-900': !(selected === '{{ $icon }}') }"
                            class="flex-shrink-0 cursor-pointer select-none relative p-2 text-gray-900 flex items-center justify-center rounded"
                        >
                            <div
                                x-state:on="Selected"
                                x-state:off="Not Selected"
                                x-bind:class="{ 'font-semibold': value === '{{ $icon }}', 'font-normal': !(value === '{{ $icon }}') }"
                                class="flex flex-col items-center truncate"
                            >
                                @icon($icon, 'h-8 w-8')
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
