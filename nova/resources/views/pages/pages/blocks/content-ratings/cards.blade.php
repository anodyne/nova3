<div
    @class([
        '@container',
        'nv-ratings nv-ratings-cards',
        'dark' => $dark,
    ])
    style="--bgColor: {{ $bgColor ?? 'transparent' }}"
>
    <x-public::block.wrapper
        :spacing-horizontal="$spacingHorizontal ?? null"
        :spacing-vertical="$spacingVertical ?? null"
    >
        <div class="nv-ratings-ctn">
            <div
                @class([
                    'nv-ratings-intro-wrapper flex',
                    'content-end justify-end' => $headerOrientation === 'right',
                ])
            >
                <div
                    @class([
                        'nv-ratings-intro-ctn max-w-2xl',
                        'mx-auto @xl:text-center' => $headerOrientation === 'center',
                        '@xl:text-right' => $headerOrientation === 'right',
                    ])
                >
                    @if (filled($heading))
                        <x-public::h2>
                            {{ $heading }}
                        </x-public::h2>
                    @endif

                    @if (filled($description))
                        <x-public::lead
                            @class([
                                'mt-6' => filled($heading),
                            ])
                            markdown
                        >
                            {{ $description }}
                        </x-public::lead>
                    @endif
                </div>
            </div>

            <div
                @class([
                    'nv-ratings-ctn grid gap-8 @xs:grid-cols-1 @4xl:grid-cols-3',
                    'mt-10' => filled($heading) || filled($description),
                ])
            >
                @foreach (['language', 'sex', 'violence'] as $ratingType)
                    @php($rating = settings("ratings.{$ratingType}"))

                    <div
                        @class([
                            'nv-ratings-card rounded-xl ring-1 ring-inset',
                            match ($rating->rating) {
                                1 => match ($dark) {
                                    true => 'nv-ratings-card-1-dark bg-yellow-950 text-yellow-300 ring-yellow-800',
                                    default => 'nv-ratings-card-1-light bg-yellow-50 text-yellow-700 ring-yellow-200'
                                },
                                2 => match ($dark) {
                                    true => 'nv-ratings-card-2-dark bg-orange-950 text-orange-300 ring-orange-800',
                                    default => 'nv-ratings-card-2-light bg-orange-50 text-orange-700 ring-orange-200'
                                },
                                3 => match ($dark) {
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
                        <x-spacing size="md" class="nv-ratings-card-rating-wrapper flex items-center gap-x-4">
                            <h3 class="nv-ratings-card-rating font-[family-name:--font-header] text-5xl font-bold">
                                {{ $rating->rating }}
                            </h3>

                            <div class="nv-ratings-card-content text-sm/6">
                                <p class="nv-ratings-card-type font-semibold">{{ ucfirst($ratingType) }}</p>
                                <p class="nv-ratings-card-description">{{ $rating->getDescription() }}</p>
                            </div>
                        </x-spacing>
                    </div>
                @endforeach
            </div>
        </div>
    </x-public::block.wrapper>
</div>
