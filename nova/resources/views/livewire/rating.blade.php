<div>
    @if ($static)
        <div>
            <span>{{ ucfirst($type[0]) }}</span>
            <span>{{ $rating }}</span>
        </div>
    @else
        <div class="flex items-center space-x-1 overflow-hidden rounded-full">
            @for ($r = 0; $r <= 3; $r++)
                <button
                    type="button"
                    wire:click="setRating({{ $r }})"
                    @class([
                        'm-0 flex-1 py-1 text-center text-base font-semibold transition md:py-0.5 md:text-sm',
                        'bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700' => $rating < $r,
                        'bg-green-500 text-white hover:bg-green-500' => $rating >= $r && $rating === 0,
                        'bg-yellow-300 text-yellow-700 hover:bg-yellow-300' => $rating >= $r && $rating === 1,
                        'bg-orange-400 text-white hover:bg-orange-400' => $rating >= $r && $rating === 2,
                        'bg-red-500 text-white hover:bg-red-500' => $rating >= $r && $rating === 3,
                    ])
                >
                    @if ($rating === $r)
                        <span>{{ $rating }}</span>
                    @else
                        <span>&nbsp;</span>
                    @endif
                </button>
            @endfor
        </div>

        <div class="relative ml-0.5 mt-2 block w-full text-base text-gray-500 md:text-sm">
            {{ settings("ratings.{$type}.description_{$rating}") }}
        </div>

        <input type="hidden" name="{{ $type }}[rating]" value="{{ $rating }}" />
    @endif
</div>
