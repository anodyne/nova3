@props([
    'value' => '#0ea5e9',
])

<div
    x-data="{
        open: false,
        ...colorPicker($refs.colorPicker, '{{ $value }}'),
    }"
    x-on:keydown.window.escape="open = false"
    x-on:click.away="open = false"
    x-on:dropdown-toggle="open = !open"
    x-on:dropdown-close.window="open = false"
    class="relative block w-full text-left leading-0"
>
    <div>
        <button
            type="button"
            x-on:click="open = !open"
            aria-haspopup="true"
            aria-expanded="true"
            x-bind:aria-expanded="open"
            class="group relative flex w-full items-center space-x-4 rounded-md bg-white px-3 py-2.5 ring-1 ring-inset ring-gray-300 dark:bg-gray-700/50 dark:ring-gray-200/[15%]"
            :class="{ 'ring-2 ring-primary-400 dark:ring-primary-700': open }"
        >
            <div
                class="flex h-4 w-4 shrink-0 items-center rounded-full"
                x-bind:style="`background-color:${color}`"
            ></div>
            <div class="flex-1 text-left text-gray-900 dark:text-white" x-text="color"></div>
            <div class="flex shrink-0 items-center text-gray-400 dark:text-gray-500">
                <x-icon name="paint-brush" size="md"></x-icon>
            </div>
        </button>
    </div>

    <div
        x-show="open"
        x-description="Dropdown panel, show/hide based on dropdown state."
        x-transition:enter="transition duration-100 ease-out"
        x-transition:enter-start="scale-95 opacity-0"
        x-transition:enter-end="scale-100 opacity-100"
        x-transition:leave="transition duration-75 ease-in"
        x-transition:leave-start="scale-100 opacity-100"
        x-transition:leave-end="scale-95 opacity-0"
        class="absolute left-0 right-auto z-[9999] mt-2 origin-bottom-left rounded-lg shadow-lg"
        x-cloak
    >
        <div
            class="z-10 divide-y divide-gray-100 rounded-lg bg-white ring-1 ring-gray-950/5 dark:divide-gray-700 dark:bg-gray-700 dark:ring-gray-700 dark:highlight-white/10"
        >
            <x-dropdown.group>
                <x-dropdown.text>
                    <div x-ref="colorPicker" class="flex items-center justify-center"></div>
                </x-dropdown.text>
            </x-dropdown.group>

            <x-dropdown.group>
                <x-dropdown.text>
                    <x-input.field>
                        <input
                            type="text"
                            {{ $attributes }}
                            x-model="inputColor"
                            class="flex-1 appearance-none border-none bg-transparent p-0 focus:text-gray-900 focus:outline-none focus:ring-0 dark:focus:text-gray-100"
                        />

                        <x-slot name="trailingAddOn">
                            <button type="button" x-on:click="colorPicker.color.set(inputColor)" class="shrink-0">
                                <x-icon name="check" size="md"></x-icon>
                            </button>
                        </x-slot>
                    </x-input.field>
                </x-dropdown.text>
            </x-dropdown.group>
        </div>
    </div>
</div>
