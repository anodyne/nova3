@props([
    'icon' => 'calendar',
    'value' => '',
])

@php($format = settings('general')->jsDateFormat())

<div
    class="relative"
    x-data="datePicker(
        @if ($attributes->hasStartsWith('wire:model'))
            @entangle($attributes->wire('model'))
        @elseif ($attributes->hasStartsWith('x-model'))
            {{ $attributes->first('x-model') }}
        @else
            @js($value)
        @endif,
        @js($format)
    )"
    @if ($attributes->hasStartsWith('x-model'))
        {{ $attributes->whereStartsWith('x-model') }}
        x-modelable="datePickerValue"
    @endif
    x-cloak
>
    <x-input.field>
        <x-slot name="leading">
            <div
                x-on:click="
                    datePickerOpen = ! datePickerOpen
                    if (datePickerOpen) {
                        $refs.datePickerInput.focus()
                    }
                "
            >
                <x-icon :name="$icon" size="md"></x-icon>
            </div>
        </x-slot>

        <input
            x-ref="datePickerInput"
            type="text"
            x-on:click="datePickerOpen = !datePickerOpen"
            x-model="datePickerDisplayValue"
            x-on:keydown.escape="datePickerOpen=false"
            class="flex-1 appearance-none border-none bg-transparent p-0 focus:text-gray-900 focus:outline-none focus:ring-0 dark:focus:text-gray-100"
            {{ $attributes->except('name') }}
            readonly
        />
        <input
            type="hidden"
            {{ $attributes->only('name') }}
            x-model="datePickerValue"
        />
    </x-input.field>

    <div
        x-show="datePickerOpen"
        x-transition
        x-on:click.away="datePickerOpen = false"
        class="absolute left-0 top-0 z-10 mt-12 w-[17rem] max-w-lg rounded-lg bg-white p-4 antialiased shadow ring-1 ring-gray-950/5 dark:bg-gray-800 dark:ring-white/20"
    >
        <div class="mb-2 flex items-center justify-between">
            <div>
                <span
                    x-text="datePickerMonthNames[datePickerMonth]"
                    class="text-lg font-bold text-gray-900 dark:text-white"
                ></span>
                <span
                    x-text="datePickerYear"
                    class="ml-1 text-lg font-normal text-gray-600 dark:text-gray-400"
                ></span>
            </div>
            <div>
                <button
                    @click="datePickerPreviousMonth()"
                    type="button"
                    class="focus:shadow-outline inline-flex cursor-pointer rounded-full p-1 transition duration-100 ease-in-out hover:bg-gray-100 focus:outline-none dark:hover:bg-gray-700"
                >
                    <svg
                        class="inline-flex size-6 text-gray-400 dark:text-gray-500"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button
                    @click="datePickerNextMonth()"
                    type="button"
                    class="focus:shadow-outline inline-flex cursor-pointer rounded-full p-1 transition duration-100 ease-in-out hover:bg-gray-100 focus:outline-none dark:hover:bg-gray-700"
                >
                    <svg
                        class="inline-flex size-6 text-gray-400 dark:text-gray-500"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="mb-3 grid grid-cols-7">
            <template x-for="(day, index) in datePickerDays" :key="index">
                <div class="px-0.5">
                    <div x-text="day" class="text-center text-xs font-medium text-gray-900 dark:text-white"></div>
                </div>
            </template>
        </div>
        <div class="grid grid-cols-7">
            <template x-for="blankDay in datePickerBlankDaysInMonth">
                <div class="border border-transparent p-1 text-center text-sm"></div>
            </template>
            <template x-for="(day, dayIndex) in datePickerDaysInMonth" :key="dayIndex">
                <div class="aspect-square mb-1 px-0.5">
                    <div
                        x-text="day"
                        @click="datePickerDayClicked(day)"
                        :class="{
                            'bg-gray-200 dark:bg-gray-600': datePickerIsToday(day) == true,
                            'text-gray-600 dark:text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-700': datePickerIsToday(day) == false && datePickerIsSelectedDate(day) == false,
                            'bg-primary-500 dark:bg-primary-500 text-white hover:bg-opacity-75': datePickerIsSelectedDate(day) == true
                        }"
                        class="flex h-7 w-7 cursor-pointer items-center justify-center rounded-full text-center text-sm leading-none"
                    ></div>
                </div>
            </template>
        </div>
    </div>
</div>
