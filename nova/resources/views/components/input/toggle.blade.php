@props([
    'field',
    'value',
    'activeColor' => 'blue-9',
    'inactiveColor' => 'gray-8',
    'disabled' => false,
])

<label
    x-data="toggleSwitch({{ $value ? 'true' : 'false'}}, {{ $disabled ? 'true' : 'false' }})"
    class="flex items-center"
    :class="{ 'cursor-not-allowed': disabled, 'cursor-pointer': !disabled }"
    x-cloak
>
    <button
        type="button"
        @click.prevent="toggle($dispatch)"
        :aria-pressed="on.toString()"
        aria-pressed="false"
        aria-labelledby="toggleLabel"
        :class="{ 'bg-{{ $inactiveColor }}': !on, 'bg-{{ $activeColor }}': on, 'opacity-50 cursor-not-allowed': disabled, 'cursor-pointer': !disabled }"
        class="relative inline-flex shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-1 focus:ring-blue-7"
    >
        <span class="sr-only">Use setting</span>
        <span aria-hidden="true" :class="{ 'translate-x-5 border-{{ $activeColor }}': on, 'translate-x-1 border-{{ $inactiveColor }}': !on }" class="bg-gray-1 translate-x-1 translate-y-0.5 inline-block h-4 w-4 rounded-full ring-0 transition ease-in-out duration-200 border"></span>
    </button>

    @if (! $slot->isEmpty())
        <span class="ml-2" id="toggleLabel">
            <span class="font-medium text-gray-11">
                {{ $slot }}
            </span>
        </span>
    @endif

    <input type="hidden" name="{{ $field }}" value="0">
    <input
        x-model="on"
        type="checkbox"
        name="{{ $field }}"
        class="hidden"
        value="1"
    >
</label>
