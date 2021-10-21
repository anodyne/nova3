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
                class="m-0 flex-1 py-0.5 text-center text-sm font-semibold transition ease-in-out duration-150"
                :class="{
                    'bg-gray-6 hover:bg-gray-9': count < {{ $i }},
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

    {{-- <div class="mt-1 text-sm text-gray-11">
        <span x-show="count === 0">Not permitted</span>
        <span x-show="count === 1">Infrequent and mild content is permitted</span>
        <span x-show="count === 2">Permitted, with some limitations</span>
        <span x-show="count === 3">Permitted, without limitations</span>
    </div> --}}

    <input type="hidden" x-model="count" {{ $attributes }}>
</div>