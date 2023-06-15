@props([
    'field',
    'value',
    'activeColor' => 'bg-primary-500',
    'disabled' => false,
])

<label x-data="toggleSwitch({{ $value ? 'true' : 'false' }}, {{ $disabled ? 'true' : 'false' }})" class="flex items-center" :class="{ 'cursor-not-allowed': disabled, 'cursor-pointer': !disabled }">
    <button type="button" x-on:click.prevent="toggle($dispatch)" :aria-pressed="on.toString()" aria-pressed="false" aria-labelledby="toggleLabel" :class="{ 'bg-gray-300': !on, '{{ $activeColor }}': on, 'opacity-50 cursor-not-allowed': disabled, 'cursor-pointer': !disabled }" class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-gray-300 transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-400 focus:ring-offset-2">
        <span class="sr-only">Use setting</span>
        <span aria-hidden="true" :class="{ 'translate-x-5': on, 'translate-x-0': !on }" class="inline-block h-5 w-5 translate-x-0 rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
    </button>

    @if (! $slot->isEmpty())
        <span class="ml-3" id="toggleLabel">
            <span class="font-medium text-gray-600">
                {{ $slot }}
            </span>
        </span>
    @endif

    <input type="hidden" name="{{ $field }}" value="0" />
    <input x-model="on" type="checkbox" name="{{ $field }}" class="hidden" value="1" />
</label>
