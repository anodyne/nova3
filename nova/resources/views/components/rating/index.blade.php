@props([
    'area',
    'value' => '',
])

{{-- format-ignore-start --}}
<div
    x-data="{
        @if ($attributes->hasStartsWith('wire:model'))
            rating: @entangle($attributes->wire('model')).live
        @elseif ($attributes->hasStartsWith('x-model'))
            rating: {{ $attributes->first('x-model') }}
        @else
            rating: @js($value)
        @endif
    }"
>
{{-- format-ignore-end --}}
    <div class="flex items-center space-x-1 overflow-hidden rounded-full">
        @for ($r = 0; $r <= 3; $r++)
            <button
                type="button"
                x-on:click="rating = {{ $r }}"
                class="m-0 flex-1 py-1 text-center text-base font-semibold transition md:py-0.5 md:text-sm"
                x-bind:class="{
                    'bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700':
                        rating < {{ $r }},
                    'bg-green-500 text-white hover:bg-green-500':
                        rating >= {{ $r }} && rating === 0,
                    'bg-yellow-300 text-yellow-700 hover:bg-yellow-300':
                        rating >= {{ $r }} && rating === 1,
                    'bg-orange-400 text-white hover:bg-orange-400':
                        rating >= {{ $r }} && rating === 2,
                    'bg-red-500 text-white hover:bg-red-500':
                        rating >= {{ $r }} && rating === 3,
                }"
            >
                <span x-show="rating === {{ $r }}" x-text="rating"></span>
                <span x-show="rating !== {{ $r }}">&nbsp;</span>
            </button>
        @endfor
    </div>

    <div class="relative ml-0.5 mt-2 block w-full text-base text-gray-500 md:text-sm">
        {{ settings("ratings.{$area}.description_{$rating}") }}
    </div>

    <input type="hidden" name="{{ $area }}[rating]" x-model="rating" />
</div>