<div>
    @if ($static)
        <div>
            <span>{{ ucfirst($type[0]) }}</span>
            <span>{{ $rating }}</span>
        </div>
    @else
        <div class="flex items-center space-x-1 rounded-full overflow-hidden">
            @for ($i = 0; $i <= 3; $i++)
                <button
                    type="button"
                    wire:click="setRating({{ $i }})"
                    @class([
                        'm-0 flex-1 py-1 md:py-0.5 text-center text-base md:text-sm font-semibold transition',
                        'bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-700' => $rating < $i,
                        'bg-success-500 hover:bg-success-500 text-white' => $rating >= $i && $rating === 0,
                        'bg-warning-300 hover:bg-warning-300 text-warning-700' => $rating >= $i && $rating === 1,
                        'bg-orange-400 hover:bg-orange-400 text-white' => $rating >= $i && $rating === 2,
                        'bg-error-500 hover:bg-error-500 text-white' => $rating >= $i && $rating === 3,
                    ])
                >
                    @if ($rating === $i)
                        <span>{{ $rating }}</span>
                    @else
                        <span>&nbsp;</span>
                    @endif
                </button>
            @endfor
        </div>

        <div class="block w-full relative mt-2 ml-0.5 text-base md:text-sm text-gray-500">
            {{ settings()->ratings->{$type}->{"description_{$rating}"} }}
        </div>

        <input type="hidden" name="{{ $type }}[rating]" value="{{ $rating }}">
    @endif
</div>
