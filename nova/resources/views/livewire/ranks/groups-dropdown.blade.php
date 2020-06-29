<div
    x-data="listBox({ value: {{ $selectedId ?? 0 }}, selected: {{ $selectedId ?? 0 }} })"
    x-init="init()"
    x-on:listbox-close.window="open = false"
    class="relative w-full"
>
    <input type="hidden" name="group_id" value="{{ $selectedId }}">

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
            class="cursor-default relative w-full rounded-md border border-gray-300 bg-white pl-3 pr-10 py-2 text-left focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition ease-in-out duration-150 | sm:text-sm sm:leading-5"
        >
            <span class="block truncate">
                {{ optional($selected)->name ?? 'Select a rank group' }}
            </span>
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
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
        class="absolute mt-1 w-full rounded-md bg-white shadow-lg z-10"
        style="display: none;"
    >
        <ul
            x-on:keydown.enter.stop.prevent="onOptionSelect()"
            x-on:keydown.escape="onEscape()"
            x-on:keydown.arrow-up.prevent="onArrowUp()"
            x-on:keydown.arrow-down.prevent="onArrowDown()"
            x-ref="listbox"
            tabindex="-1"
            role="listbox"
            aria-labelledby="listbox-label"
            x-bind:aria-activedescendant="activeDescendant"
            class="max-h-60 rounded-md py-1 text-base leading-6 shadow-xs overflow-auto focus:outline-none | sm:text-sm sm:leading-5"
            aria-activedescendant="listbox-option-0"
        >
            <li class="p-2">
                <div class="flex items-center rounded bg-gray-100 border-2 border-gray-100 text-gray-600 px-2 py-2 focus-within:border-gray-200 focus-within:bg-white focus-within:text-gray-700">
                    <div class="flex-shrink-0 mr-3">
                        @icon('search', 'h-5 w-5')
                    </div>
                    <input wire:model.debounce.250ms="query" type="text" placeholder="Find a rank group..." class="block w-full appearance-none bg-transparent focus:outline-none">
                </div>
            </li>

            @forelse ($groups as $group)
                <li
                    x-description="Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation."
                    x-state:on="Highlighted"
                    x-state:off="Not Highlighted"
                    id="listbox-option-{{ $group->id }}"
                    role="option"
                    wire:click="selectGroup({{ $group->id }})"
                    x-on:mouseenter="selected = {{ $group->id }}"
                    x-on:mouseleave="selected = null"
                    x-bind:class="{ 'text-white bg-blue-600': selected === {{ $group->id }}, 'text-gray-900': !(selected === {{ $group->id }}) }"
                    class="cursor-default select-none relative py-2 pl-3 pr-9 text-gray-900"
                >
                    <span
                        x-state:on="Selected"
                        x-state:off="Not Selected"
                        x-bind:class="{ 'font-semibold': value === {{ $group->id }}, 'font-normal': !(value === {{ $group->id }}) }"
                        class="block truncate font-semibold"
                    >
                        {{ $group->name }}
                    </span>

                    @if ($selectedId === $group->id)
                        <span
                            x-description="Checkmark, only display for selected option."
                            x-state:on="Highlighted"
                            x-state:off="Not Highlighted"
                            x-bind:class="{ 'text-white': selected === {{ $group->id }}, 'text-blue-600': !(selected === {{ $group->id }}) }"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-blue-600"
                        >
                            @icon('check', 'h-5 w-5')
                        </span>
                    @endif
                </li>
            @empty
                <li class="py-4">
                    <div class="text-center">
                        <div class="text-gray-500">There is no rank group named</div>
                        <div class="text-gray-800 font-medium mt-1">&lsquo;{{ $query }}&rsquo;</div>

                        <button wire:click="createAndSelectGroup" type="button" class="mt-6 button button-primary">
                            Create this group
                        </button>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>
</div>

@push('scripts')
    <script>
        function listBox(options = {})
        {
            return {
                open: false,
                value: 0,
                selected: 0,
                activeDescendant: 'listbox-option-0',
                ...options,

                init () {},

                onButtonClick () {
                    this.open = !this.open;
                    this.$refs.listbox.focus();
                },

                onEscape () {
                    this.open = false;
                },

                onOptionSelect () {},

                onArrowUp () {
                    this.selected--;
                },

                onArrowDown () {
                    this.selected++;
                },

                choose (value) {
                    this.value = value;
                    this.selected = value;
                    this.open = false;
                }
            };
        }
    </script>
@endpush
