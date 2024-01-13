<div data-slot="control">
    <div class="flex items-center gap-x-[3px] overflow-hidden rounded-full">
        @for ($r = 0; $r <= 3; $r++)
            <button
                type="button"
                wire:click="$set('value', {{ $r }})"
                @class([
                    'm-0 flex-1 py-1 text-center text-base font-semibold transition md:py-0.5 md:text-sm',
                    'bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700' => $value < $r,
                    'bg-green-500 text-white hover:bg-green-500' => $value >= $r && $value === 0,
                    'bg-yellow-300 text-yellow-700 hover:bg-yellow-300' => $value >= $r && $value === 1,
                    'bg-orange-400 text-white hover:bg-orange-400' => $value >= $r && $value === 2,
                    'bg-red-500 text-white hover:bg-red-500' => $value >= $r && $value === 3,
                ])
            >
                @if ($value === $r)
                    <span>{{ $value }}</span>
                @else
                    <span>&nbsp;</span>
                @endif
            </button>
        @endfor
    </div>

    <x-text class="mt-2">
        {{ settings("ratings.{$area}.description_{$value}") }}
    </x-text>

    <input type="hidden" name="{{ $area }}[rating]" value="{{ $value }}" />
</div>
