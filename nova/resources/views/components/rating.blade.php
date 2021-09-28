@props([
    'value',
    'static' => false,
])

<div x-data="ratings" class="flex items-center space-x-1 rounded-full overflow-hidden">
    @for ($i = 0; $i <= 3; $i++)
        <button
            x-bind="rating({{ $i }})"
            type="button"
            @click="setCount({{ $i }})"
            class="m-0 flex-1 py-0.5 bg-gray-6 hover:bg-gray-9 text-center text-sm font-semibold transition ease-in-out duration-150"
            :class="{
                'bg-green-9 hover:bg-green-9 text-gray-1': count >= {{ $i }} && count === 0,
                'bg-yellow-9 hover:bg-yellow-9 text-gray-12': count >= {{ $i }} && count === 1,
                'bg-orange-9 hover:bg-orange-9 text-gray-1': count >= {{ $i }} && count === 2,
                'bg-red-9 hover:bg-red-9 text-gray-1': count >= {{ $i }} && count === 3
            }"
        >
            <span x-show="count === {{ $i }}" x-text="count"></span>
            <span x-show="count !== {{ $i }}">&nbsp;</span>
        </button>
    @endfor
</div>