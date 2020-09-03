@props([
    'items',
])

<div x-data="listBox()" x-init="init()" {{ $attributes->merge(['class' => 'relative']) }}>
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
            class="cursor-default relative w-full rounded-md border border-gray-300 bg-white pl-3 pr-10 py-2 text-left focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition ease-in-out duration-150 | sm:text-sm"
        >
            <span
                x-text="['Wade Cooper','Arlene Mccoy','Devon Webb','Tom Cook','Tanya Fox','Hellen Schmidt','Caroline Schultz','Mason Heaney','Claudie Smitham','Emil Schaefer'][value]"
                class="block truncate"
            >
                Wade Cooper
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
        class="absolute mt-1 w-full rounded-md bg-white shadow-lg"
        style="display: none;"
    >
        <ul
            x-on:keydown.enter.stop.prevent="onOptionSelect()"
            x-on:keydown.space.stop.prevent="onOptionSelect()"
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
            {{-- <template x-for="item in items">
                <li
                    x-description="Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation."
                    x-state:on="Highlighted"
                    x-state:off="Not Highlighted"
                    id="listbox-option-0"
                    role="option"
                    x-on:click="choose(item.id)"
                    x-on:mouseenter="selected = item.id"
                    x-on:mouseleave="selected = null"
                    x-bind:class="{ 'text-white bg-blue-600': selected === item.id, 'text-gray-900': !(selected === item.id) }"
                    class="cursor-default select-none relative py-2 pl-3 pr-9 text-gray-900"
                >
                    <span
                        x-state:on="Selected"
                        x-state:off="Not Selected"
                        x-bind:class="{ 'font-semibold': value === item.id, 'font-normal': !(value === item.id) }"
                        x-text="item.name"
                        class="block truncate font-semibold"
                    ></span>

                    <span
                        x-show="value === item.id"
                        x-description="Checkmark, only display for selected option."
                        x-state:on="Highlighted"
                        x-state:off="Not Highlighted"
                        x-bind:class="{ 'text-white': selected === item.id, 'text-blue-600': !(selected === item.id) }"
                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-blue-600"
                    >
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </span>
                </li>
            </template> --}}

            @foreach ($items as $item)
                <li
                    x-description="Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation."
                    x-state:on="Highlighted"
                    x-state:off="Not Highlighted"
                    id="listbox-option-0"
                    role="option"
                    x-on:click="choose({{ $item->id }})"
                    x-on:mouseenter="selected = {{ $item->id }}"
                    x-on:mouseleave="selected = null"
                    x-bind:class="{ 'text-white bg-blue-600': selected === {{ $item->id }}, 'text-gray-900': !(selected === {{ $item->id }}) }"
                    class="cursor-default select-none relative py-2 pl-3 pr-9 text-gray-900"
                >
                    <span
                        x-state:on="Selected"
                        x-state:off="Not Selected"
                        x-bind:class="{ 'font-semibold': value === {{ $item->id }}, 'font-normal': !(value === {{ $item->id }}) }"
                        class="block truncate font-semibold"
                    >
                        {{ $item->name }}
                    </span>

                    <span
                        x-show="value === {{ $item->id }}"
                        x-description="Checkmark, only display for selected option."
                        x-state:on="Highlighted"
                        x-state:off="Not Highlighted"
                        x-bind:class="{ 'text-white': selected === {{ $item->id }}, 'text-blue-600': !(selected === {{ $item->id }}) }"
                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-blue-600"
                    >
                        @icon('check', 'h-5 w-5')
                    </span>
                </li>
            @endforeach
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
