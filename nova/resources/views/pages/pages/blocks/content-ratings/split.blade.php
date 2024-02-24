<div class="@container nv-ratings nv-ratings-grid">
    <div
        class="nv-ratings-wrapper relative isolate overflow-hidden font-[family-name:--font-body]"
        @isset($backgroundColor)
            style="background-color:{{ $backgroundColor }}"
        @endisset
    >
        <div class="nv-stats-wrapper @xs:px-6 @xs:py-8 @lg:py-12 @lg:px-8 relative z-10 mx-auto max-w-7xl">
            @if (filled($heading) || filled($description))
                <div class="nv-stats-content-wrapper mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                    @if (filled($heading))
                        <h2
                            @class([
                                'nv-stats-heading font-[family-name:--font-header] text-3xl font-bold tracking-tight sm:text-4xl',
                                'text-gray-900' => ! $dark,
                                'text-white' => $dark,
                            ])
                        >
                            {{ $heading }}
                        </h2>
                    @endif

                    <div
                        @class([
                            'nv-stats-wrapper flex flex-col gap-x-8 gap-y-20 lg:flex-row',
                            'mt-6' => filled($heading),
                        ])
                    >
                        @if (filled($description))
                            <div class="nv-stats-content-ctn lg:w-full lg:max-w-2xl lg:flex-auto">
                                <div
                                    @class([
                                        'nv-stats-description space-y-6 text-lg/8',
                                        'text-gray-600' => ! $dark,
                                        'text-gray-400' => $dark,
                                    ])
                                >
                                    {!! str($description)->markdown() !!}
                                </div>
                            </div>
                        @endif

                        <div class="nv-stats-ctn lg:flex lg:flex-auto lg:justify-center">
                            <dl class="w-64 space-y-8 xl:w-80">
                                @foreach (['language', 'sex', 'violence'] as $ratingType)
                                    @php($rating = settings("ratings.{$ratingType}"))

                                    <div class="flex items-center gap-x-3">
                                        <dd
                                            @class([
                                                'w-12 text-center font-[family-name:--font-header] text-5xl font-semibold tracking-tight',
                                                'text-gray-900' => ! $dark,
                                                'text-white' => $dark,
                                            ])
                                        >
                                            {{ $rating->rating }}
                                        </dd>
                                        <dt
                                            @class([
                                                'text-sm/6',
                                                'text-gray-600' => ! $dark,
                                                'text-gray-400' => $dark,
                                            ])
                                        >
                                            <p class="font-semibold">{{ ucfirst($ratingType) }}</p>
                                            <p>{{ $rating->getDescription() }}</p>
                                        </dt>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
