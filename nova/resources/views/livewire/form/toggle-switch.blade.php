<div>
    <label wire:click="toggle()" class="flex items-center">
        <span
            class="relative inline-block flex-no-shrink h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:shadow-outline @if ($active) {{ $color }} @else bg-gray-200 dark:bg-gray-700 @endif"
            role="switch"
            tabindex="0"
            {{-- x-bind:aria-checked="{{ (string) $active }}" --}}
        >
            <span
                aria-hidden="true"
                class="relative inline-block h-5 w-5 rounded-full bg-white shadow transform transition ease-in-out duration-200 @if ($active) translate-x-5 @else translate-x-0 @endif"
            >
                <span class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity @if ($active) opacity-0 ease-out duration-100 @else opacity-100 ease-in duration-200 @endif">
                    {{-- <slot name="icon-off" v-bind="iconProps">
                        <svg
                            :class="styles.iconOff"
                            fill="none"
                            viewBox="0 0 12 12"
                        >
                            <path
                                d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </slot> --}}
                </span>
                <span class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity @if ($active) opacity-100 ease-in duration-200 @else opacity-0 ease-out duration-100 @endif">
                    {{-- <slot name="icon-on" v-bind="iconProps">
                        <svg
                            :class="styles.iconOn"
                            fill="currentColor"
                            viewBox="0 0 12 12"
                        >
                            <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
                        </svg>
                    </slot> --}}
                </span>
            </span>
        </span>

        @if (isset($label))
            <div class="ml-3 font-medium text-gray-700">
                {{ $label }}
            </div>
        @endif
    </label>

    <input type="checkbox" name="{{ $fieldName }}" value="{{ $active ?: '0' }}" class="hidden" checked>
</div>
