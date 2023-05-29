@props([
    'value' => '#0ea5e9',
])

<div
    x-data="{ open: false, ...colorPicker($refs.colorPicker, '{{ $value }}') }"
    @keydown.window.escape="open = false"
    @click.away="open = false"
    @dropdown-toggle="open = !open"
    @dropdown-close.window="open = false"
    class="relative block w-full text-left leading-0"
>
    <div>
        <button
            type="button"
            @click="open = !open"
            aria-haspopup="true"
            aria-expanded="true"
            x-bind:aria-expanded="open"
            class="group relative flex items-center space-x-4 ring-1 ring-inset ring-gray-300 dark:ring-gray-200/[15%] py-2.5 px-3 bg-white dark:bg-gray-700/50 rounded-md w-full"
            :class="{ 'ring-2 ring-primary-400 dark:ring-primary-700': open }"
        >
            <div class="h-4 w-4 rounded-full flex items-center shrink-0" x-bind:style=`background-color:${color}`></div>
            <div class="flex-1 text-gray-900 dark:text-white text-left" x-text="color"></div>
            <div class="text-gray-400 dark:text-gray-500 flex items-center shrink-0">
                <x-icon name="paint-brush" size="md"></x-icon>
            </div>
        </button>
    </div>

    <div
        x-show="open"
        x-description="Dropdown panel, show/hide based on dropdown state."
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute mt-2 rounded-lg shadow-lg z-[9999] left-0 right-auto origin-bottom-left"
        x-cloak
    >
        <div class="rounded-lg bg-white dark:bg-gray-700 ring-1 ring-gray-900/5 dark:ring-gray-700 z-10 divide-y divide-gray-100 dark:divide-gray-700 dark:highlight-white/10">
            <x-dropdown.group>
                <x-dropdown.text>
                    <div x-ref="colorPicker" class="flex items-center justify-center"></div>
                </x-dropdown.text>
            </x-dropdown.group>

            <x-dropdown.group>
                <x-dropdown.text>
                    <x-input.field>
                        <input type="text" {{ $attributes }} x-model="inputColor" class="flex-1 appearance-none bg-transparent border-none p-0 focus:ring-0 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100">

                        <x-slot:trailingAddOn>
                            <button type="button" @click="colorPicker.color.set(inputColor)" class="shrink-0">
                                <x-icon name="check" size="md"></x-icon>
                            </button>
                        </x-slot:trailingAddOn>
                    </x-input.field>
                </x-dropdown.text>
            </x-dropdown.group>
        </div>
    </div>
</div>
