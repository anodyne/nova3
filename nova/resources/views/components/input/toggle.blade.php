@props([
    'field',
    'value',
    'activeColor' => 'bg-blue-600',
    'disabled' => false,
])

<label
    x-data="AlpineComponents.toggleSwitch({{ $value ? 'true' : 'false'}}, {{ $disabled ? 'true' : 'false' }})"
    class="flex items-center"
    x-bind:class="{ 'cursor-not-allowed': disabled, 'cursor-pointer': !disabled }"
>
    <button
        type="button"
        x-on:click.prevent="toggle($dispatch)"
        x-bind:aria-pressed="on.toString()"
        aria-pressed="false"
        aria-labelledby="toggleLabel"
        x-bind:class="{ 'bg-gray-200': !on, '{{ $activeColor }}': on, 'opacity-50 cursor-not-allowed': disabled, 'cursor-pointer': !disabled }"
        class="bg-gray-200 relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
    >
        <span class="sr-only">Use setting</span>
        <span aria-hidden="true" x-bind:class="{ 'translate-x-5': on, 'translate-x-0': !on }" class="translate-x-0 inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
    </button>

    @if (! $slot->isEmpty())
        <span class="ml-3" id="toggleLabel">
            <span class="font-medium text-gray-900">
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
