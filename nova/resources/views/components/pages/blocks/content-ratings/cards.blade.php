@use('Nova\Stories\Enums\ContentRatingValue')

@php
    $dark = data_get($block, 'dark');
@endphp

<x-public::block.container :$container :$content :$block class="nv-ratings nv-ratings-cards">
    <div
        @class([
            'nv-ratings-ctn grid gap-8 @xs:grid-cols-1 @4xl:grid-cols-3',
            'mt-10' => filled($content, 'heading.text') || filled($content, 'message.text') || filled($content, 'callout.text'),
        ])
    >
        @foreach (['language', 'sex', 'violence'] as $ratingType)
            @php($rating = settings("ratings.{$ratingType}"))

            <div
                @class([
                    'nv-ratings-card rounded-xl ring-1 ring-inset',
                    match ($rating->rating) {
                        ContentRatingValue::Level1 => match ($dark) {
                            true => 'nv-ratings-card-1-dark bg-yellow-950 text-yellow-300 ring-yellow-800',
                            default => 'nv-ratings-card-1-light bg-yellow-50 text-yellow-700 ring-yellow-200'
                        },
                        ContentRatingValue::Level2 => match ($dark) {
                            true => 'nv-ratings-card-2-dark bg-orange-950 text-orange-300 ring-orange-800',
                            default => 'nv-ratings-card-2-light bg-orange-50 text-orange-700 ring-orange-200'
                        },
                        ContentRatingValue::Level3 => match ($dark) {
                            true => 'nv-ratings-card-3-dark bg-red-950 text-red-300 ring-red-800',
                            default => 'nv-ratings-card-3-light bg-red-50 text-red-700 ring-red-200'
                        },
                        default => match ($dark) {
                            true => 'nv-ratings-card-0-dark bg-green-950 text-green-300 ring-green-800',
                            default => 'nv-ratings-card-0-light bg-green-50 text-green-700 ring-green-200'
                        },
                    },
                ])
            >
                <x-spacing size="md" class="nv-ratings-card-rating-wrapper flex gap-x-4">
                    <h3 class="nv-ratings-card-rating font-(family-name:--font-header) text-5xl font-bold">
                        {{ $rating->rating->value }}
                    </h3>

                    <div class="nv-ratings-card-content text-sm/6">
                        <p class="nv-ratings-card-type font-semibold">{{ ucfirst($ratingType) }}</p>
                        <p class="nv-ratings-card-description">{{ $rating->getDescription() }}</p>
                    </div>
                </x-spacing>
            </div>
        @endforeach
    </div>
</x-public::block.container>
