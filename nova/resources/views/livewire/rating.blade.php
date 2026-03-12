@use('Nova\Stories\Enums\ContentRatingValue')

<div data-slot="control">
    <x-field>
        <x-slider
            wire:model.live="value"
            min="0"
            max="3"
            track:class="h-5"
            thumb:class="size-5"
            @class([
                '**:data-flux-slider-indicator:bg-gray-300 dark:**:data-flux-slider-indicator:bg-white/15' => $value === ContentRatingValue::Level0,
                '**:data-flux-slider-indicator:bg-yellow-300 dark:**:data-flux-slider-indicator:bg-yellow-300' => $value === ContentRatingValue::Level1,
                '**:data-flux-slider-indicator:bg-orange-400 dark:**:data-flux-slider-indicator:bg-orange-400' => $value === ContentRatingValue::Level2,
                '**:data-flux-slider-indicator:bg-red-500 dark:**:data-flux-slider-indicator:bg-red-500' => $value === ContentRatingValue::Level3,
            ])
        >
            @foreach (range(0, 3) as $i)
                <x-slider.tick :value="$i">{{ $i }}</x-slider.tick>
            @endforeach
        </x-slider>

        <x-description>
            {{ settings("ratings.{$area}.description{$value->value}") }}
        </x-description>
    </x-field>

    <div class="hidden flex items-center gap-x-[3px] overflow-hidden rounded-full">
        @foreach (ContentRatingValue::casesForRatings() as $rating)
            <button
                type="button"
                wire:click="$set('value', {{ $rating }})"
                @class([
                    'm-0 flex-1 py-1 text-center text-base font-semibold transition md:py-0.5 md:text-sm',
                    'bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700' => $value->value < $rating->value,
                    'bg-green-500 text-white hover:bg-green-500' => $value->value >= $rating->value && $value === ContentRatingValue::Level0,
                    'bg-yellow-300 text-yellow-700 hover:bg-yellow-300' => $value->value >= $rating->value && $value === ContentRatingValue::Level1,
                    'bg-orange-400 text-white hover:bg-orange-400' => $value->value >= $rating->value && $value === ContentRatingValue::Level2,
                    'bg-red-500 text-white hover:bg-red-500' => $value->value >= $rating->value && $value === ContentRatingValue::Level3,
                ])
            >
                @if ($value === $rating)
                    <span>{{ $value->value }}</span>
                @else
                    <span>&nbsp;</span>
                @endif
            </button>
        @endforeach
    </div>

    <x-text class="hidden mt-2">
        {{ settings("ratings.{$area}.description{$value->value}") }}
    </x-text>

    <input type="hidden" name="{{ $area }}[rating]" value="{{ $value->value }}"/>
</div>
