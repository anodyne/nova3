@props([
    'field',
    'value',
    'activeIcon' => false,
    'activeText' => false,
    'disabled' => false,
    'inactiveIcon' => false,
    'inactiveText' => false,
])

<label
    x-data="toggleSwitch({{ $value ? 'true' : 'false' }}, {{ $disabled ? 'true' : 'false' }})"
    x-on:click.prevent="toggle($dispatch)"
    x-on:keydown.space.prevent="toggle($dispatch)"
    class="flex items-center @if ($disabled) opacity-50 cursor-not-allowed @else cursor-pointer @endif"
>
    <span
        x-bind:class="{ 'bg-gray-200': !active, 'bg-blue-500': active }"
        class="relative inline-block flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full transition-colors ease-in-out duration-200 focus:outline-none focus:shadow-outline"
        role="switch"
        tabindex="0"
        x-bind:aria-checked="active.toString()"
    >
        <span
            aria-hidden="true"
            x-bind:class="{ 'translate-x-5': active, 'translate-x-0': !active }"
            class="relative inline-block h-5 w-5 rounded-full bg-white shadow transform transition ease-in-out duration-200"
        >
            <span
                x-bind:class="{ 'opacity-0 ease-out duration-100': active, 'opacity-100 ease-in duration-200': !active }"
                class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity"
            >
                {{ $inactiveIcon }}
            </span>
            <span
                x-bind:class="{ 'opacity-100 ease-in duration-200': active, 'opacity-0 ease-out duration-100': !active }"
                class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity"
            >
                {{ $activeIcon }}
            </span>
        </span>
    </span>

    <div class="ml-3 font-medium text-gray-700">
        {{ $slot }}

        <div x-show="!active">
            {{ $inactiveText }}
        </div>

        <div x-show="active">
            {{ $activeText }}
        </div>
    </div>

    <input type="hidden" name="{{ $field }}" value="0">
    <input
        x-model="active"
        type="checkbox"
        name="{{ $field }}"
        class="hidden"
        value="1"
    >
</label>

@push('scripts')
<script>
    function toggleSwitch (active, disabled) {
        return {
            active: active,
            disabled: disabled,

            toggle ($dispatch) {
                if (! this.disabled) {
                    this.active = !this.active;
                    $dispatch('toggle-changed', Boolean(this.active));
                }
            }
        }
    }
</script>
@endpush
