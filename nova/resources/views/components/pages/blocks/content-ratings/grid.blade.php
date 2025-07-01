@use('Nova\Stories\Enums\ContentRatingValue')

@php
    $dark = data_get($block, 'dark');
@endphp

<x-public::block.container :$container :$content :$block class="nv-ratings nv-ratings-grid">
    <div
        @class([
            'nv-ratings-ctn grid gap-8 @xs:grid-cols-1 @4xl:grid-cols-3',
            'mt-10' => filled($content, 'heading.text') || filled($content, 'message.text') || filled($content, 'callout.text'),
        ])
    >
        @foreach (['language', 'sex', 'violence'] as $ratingType)
            @php($rating = settings("ratings.{$ratingType}"))

            <div class="nv-ratings-grid-item-rating-wrapper flex items-center gap-x-3">
                <div
                    @class([
                        'nv-ratings-grid-item flex h-12 w-12 items-center justify-center rounded-xl font-[family-name:--font-header] text-4xl font-bold ring-1 ring-inset',
                        match ($rating->rating) {
                            ContentRatingValue::Level1 => match ($dark) {
                                true => 'nv-ratings-grid-item-1-dark bg-yellow-500 text-white ring-white/20',
                                default => 'nv-ratings-grid-item-1-light bg-yellow-500 text-white ring-gray-950/15'
                            },
                            ContentRatingValue::Level2 => match ($dark) {
                                true => 'nv-ratings-grid-item-2-dark bg-orange-500 text-white ring-white/20',
                                default => 'nv-ratings-grid-item-2-light bg-orange-500 text-white ring-gray-950/15'
                            },
                            ContentRatingValue::Level3 => match ($dark) {
                                true => 'nv-ratings-grid-item-3-dark bg-red-500 text-white ring-white/20',
                                default => 'nv-ratings-grid-item-3-light bg-red-500 text-white ring-gray-950/15'
                            },
                            default => match ($dark) {
                                true => 'nv-ratings-grid-item-0-dark bg-green-500 text-white ring-white/20',
                                default => 'nv-ratings-grid-item-0-light bg-green-500 text-white ring-gray-950/15'
                            },
                        },
                    ])
                >
                    {{ $rating->rating->value }}
                </div>

                <div class="nv-ratings-grid-item-content text-sm/5">
                    <p
                        @class([
                            'nv-ratings-grid-item-type font-semibold',
                            'text-white' => ! $dark,
                            'text-gray-950' => $dark,
                        ])
                    >
                        {{ ucfirst($ratingType) }}
                    </p>
                    <p class="nv-ratings-grid-item-description text-gray-500">
                        {{ $rating->getDescription() }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</x-public::block.container>
