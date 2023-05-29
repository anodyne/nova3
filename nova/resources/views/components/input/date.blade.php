@props([
    'format' => 'yyyy-mm-dd',
    'icon' => 'calendar',
    'value' => '',
])

<div x-data="datePicker($refs.date)" class="relative">
    <x-input.field>
        <x-slot:leadingAddOn>
            <x-icon name="calendar" size="md"></x-icon>
        </x-slot:leadingAddOn>

        <input
            type="text"
            x-ref="date"
            class="flex-1 appearance-none bg-transparent border-none p-0 focus:ring-0 focus:outline-none focus:text-gray-900 dark:focus:text-gray-100"
            value="{{ $value }}"
            {{ $attributes }}
            datepicker
            datepicker-autohide
            datepicker-orientation="bottom left"
            datepicker-format="{{ $format }}"
        >
    </x-input.field>
</div>
