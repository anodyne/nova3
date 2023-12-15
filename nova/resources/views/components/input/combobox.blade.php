@props([
    'value' => '',
    'items' => [],
    'offset' => 8,
    'placement' => null,
    'shift' => false,
    'teleport' => false,
])

<div
    x-data="{
        query: '',
        @if ($attributes->hasStartsWith('wire:model'))
            selected: $wire.entangle('{{ $attributes->wire('model')->value() }}').live,
        @elseif ($attributes->hasStartsWith('x-model'))
            selected: {{ $attributes->first('x-model') }},
        @else
            selected: {{ Illuminate\Support\Js::from($value) }},
        @endif
        items: @js($items),
        get filteredItems() {
            return this.query === ''
                ? this.items
                : this.items.filter((item) => {
                      return item.name
                          .toLowerCase()
                          .includes(this.query.toLowerCase())
                  })
        },
    }"
    class="w-full max-w-xs"
>
    <div x-combobox x-model="selected" class="relative">
        <x-input.field>
            <div class="flex w-full items-center justify-between gap-2">
                <input
                    x-combobox:input
                    :display-value="item => item.name"
                    x-on:change="query = $event.target.value;"
                    class="border-none p-0 focus:outline-none focus:ring-0"
                    placeholder="Search..."
                />
                <button x-combobox:button class="absolute inset-y-0 right-0 flex items-center pr-2">
                    <!-- Heroicons up/down -->
                    <svg class="h-5 w-5 shrink-0 text-gray-500" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                        <path
                            d="M7 7l3-3 3 3m0 6l-3 3-3-3"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </button>
            </div>
        </x-input.field>

        <div
            x-combobox:options
            x-cloak
            class="absolute z-10 mt-2 max-h-60 w-full max-w-xs origin-top-right overflow-auto rounded-md border border-gray-200 bg-white shadow-md outline-none"
            x-transition.out.opacity
            x-ref="panel"
            x-float{{ $placement ? ".placement.{$placement}" : '' }}.flip{{ $shift ? '.shift' : '' }}{{ $teleport ? '.teleport' : '' }}{{ $offset ? '.offset' : '' }}="{ offset: {{ $offset }} }"
        >
            <ul class="divide-y divide-gray-100">
                <template x-for="item in filteredItems" :key="item.id" hidden>
                    <li
                        x-combobox:option
                        :value="item"
                        :disabled="item.disabled"
                        :class="{
                            'bg-success-500/10 text-gray-900': $comboboxOption.isActive,
                            'text-gray-600': ! $comboboxOption.isActive,
                            'opacity-50 cursor-not-allowed': $comboboxOption.isDisabled,
                        }"
                        class="flex w-full cursor-default items-center justify-between gap-2 px-4 py-2 text-sm"
                    >
                        <span x-text="item.name"></span>

                        <span x-show="$comboboxOption.isSelected" class="font-bold text-success-500">&check;</span>
                    </li>
                </template>
            </ul>

            <p x-show="filteredItems.length == 0" class="px-4 py-2 text-sm text-gray-600">
                No items match your query.
            </p>
        </div>
        {{--
            <div class="relative mt-1 rounded-md focus-within:ring-2 focus-within:ring-primary-500">
            
            </div>
        --}}
    </div>
</div>

@pushOnce('scripts')
<script defer src="https://unpkg.com/@alpinejs/ui@3.13.3-beta.4/dist/cdn.min.js"></script>
@endPushOnce
