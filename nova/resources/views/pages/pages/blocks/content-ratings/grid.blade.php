<div
    @class([
        '@container',
        'nv-ratings nv-ratings-grid',
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

                    <div class="nv-ratings-grid-item-rating-wrapper flex items-center gap-x-3">
                        <div
                            @class([
                                'nv-ratings-grid-item flex h-12 w-12 items-center justify-center rounded-xl font-[family-name:--font-header] text-4xl font-bold ring-1 ring-inset',
                                match ($rating->rating) {
                                    1 => match ($dark) {
                                        true => 'nv-ratings-grid-item-1-dark bg-yellow-500 text-white ring-white/20',
                                        default => 'nv-ratings-grid-item-1-light bg-yellow-500 text-white ring-gray-950/15'
                                    },
                                    2 => match ($dark) {
                                        true => 'nv-ratings-grid-item-2-dark bg-orange-500 text-white ring-white/20',
                                        default => 'nv-ratings-grid-item-2-light bg-orange-500 text-white ring-gray-950/15'
                                    },
                                    3 => match ($dark) {
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
                            {{ $rating->rating }}
                        </div>

                        <div class="nv-ratings-grid-item-content text-sm/5">
                            <p
                                @class([
                                    'nv-ratings-grid-item-type font-semibold',
                                    'text-gray-600' => ! $dark,
                                    'text-gray-400' => $dark,
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
        </div>
    </x-public::block.wrapper>
</div>
