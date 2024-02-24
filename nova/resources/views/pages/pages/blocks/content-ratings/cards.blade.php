<div class="@container nv-ratings nv-ratings-cards">
    <div
        class="nv-ratings-wrapper relative isolate overflow-hidden font-[family-name:--font-body]"
        @isset($backgroundColor)
            style="background-color:{{ $backgroundColor }}"
        @endisset
    >
        <div class="nv-ratings-ctn @xs:px-6 @xs:py-8 @lg:py-12 @lg:px-8 relative z-10 mx-auto max-w-7xl">
            <div
                @class([
                    'nv-ratings-intro-wrapper flex',
                    'content-end justify-end' => $orientation === 'right',
                ])
            >
                <div
                    @class([
                        'nv-ratings-intro-ctn max-w-2xl',
                        'mx-auto @lg:text-center' => $orientation === 'center',
                        '@lg:text-right' => $orientation === 'right',
                    ])
                >
                    @if (filled($heading))
                        <h2
                            @class([
                                'nv-ratings-heading font-[family-name:--font-header] text-3xl font-bold tracking-tight sm:text-4xl',
                                'text-gray-900' => ! $dark,
                                'text-white' => $dark,
                            ])
                        >
                            {{ $heading }}
                        </h2>
                    @endif

                    @if (filled($description))
                        <div
                            @class([
                                'nv-ratings-description space-y-6 text-lg/8',
                                'text-gray-600' => ! $dark,
                                'text-gray-300' => $dark,
                                'mt-6' => filled($heading),
                            ])
                        >
                            {!! str($description)->markdown() !!}
                        </div>
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
    </div>
</div>
