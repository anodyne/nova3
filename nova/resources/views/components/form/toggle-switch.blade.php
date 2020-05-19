<label
    x-data="toggleSwitch()"
    x-on:click="active = !active"
    x-on:keydown.space.prevent="active = !active"
    class="flex items-center cursor-pointer"
>
    <span
        x-bind:class="{ 'bg-gray-200': !active, 'bg-blue-500': active }"
        class="relative inline-block flex-no-shrink h-6 w-11 border-2 border-transparent rounded-full transition-colors ease-in-out duration-200 focus:outline-none focus:shadow-outline"
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
                {{ $iconInactive ?? false }}
            </span>
            <span
                x-bind:class="{ 'opacity-100 ease-in duration-200': active, 'opacity-0 ease-out duration-100': !active }"
                class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity"
            >
                {{ $iconActive ?? false }}
            </span>
        </span>
    </span>

    <div class="ml-3 font-medium text-gray-700">
        {{ $slot ?? false }}

        <div x-show="!active">
            {{ $contentInactive ?? false }}
        </div>

        <div x-show="active">
            {{ $contentActive ?? false }}
        </div>
    </div>

    <input type="hidden" name="{{ $name }}" value="0">
    <input
        type="checkbox"
        name="{{ $name }}"
        class="hidden"
        x-model="active"
        value="1"
    >
</label>

@push('scripts')
<script>
    const active = {{ $value ? 'true' : 'false' }};

    function toggleSwitch () {
        return {
            active: active
        }
    }
</script>
@endpush