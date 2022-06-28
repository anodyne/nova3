@props([
    'value' => 0,
    'static' => false,
])

<div x-data="ratings({{ $value }})">
    <div class="flex items-center space-x-1 rounded-full overflow-hidden">
        @for ($i = 0; $i <= 3; $i++)
            <button
                x-bind="rating({{ $i }})"
                type="button"
                @click="setCount({{ $i }})"
                class="m-0 flex-1 py-1 md:py-0.5 text-center text-base md:text-sm font-semibold transition ease-in-out duration-200"
                :class="{
                    'bg-gray-200 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-600': count < {{ $i }},
                    'bg-success-500 hover:bg-success-500 text-white': count >= {{ $i }} && count === 0,
                    'bg-warning-500 hover:bg-warning-500 text-white': count >= {{ $i }} && count === 1,
                    'bg-orange-500 hover:bg-orange-500 text-white': count >= {{ $i }} && count === 2,
                    'bg-error-500 hover:bg-error-500 text-white': count >= {{ $i }} && count === 3
                }"
            >
                <span x-show="count === {{ $i }}" x-text="count"></span>
                <span x-show="count !== {{ $i }}">&nbsp;</span>
            </button>
        @endfor
    </div>

    {{-- <div class="mt-1 text-sm text-gray-600">
        <span x-show="count === 0">Not permitted</span>
        <span x-show="count === 1">Infrequent and mild content is permitted</span>
        <span x-show="count === 2">Permitted, with some limitations</span>
        <span x-show="count === 3">Permitted, without limitations</span>
    </div> --}}

    <input type="hidden" x-model="count" {{ $attributes }}>
</div>
