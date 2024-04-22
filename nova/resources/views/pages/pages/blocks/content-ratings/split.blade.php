<div
    @class([
        '@container',
        'nv-ratings nv-ratings-split',
        'dark' => $dark,
    ])
    style="--bgColor: {{ $bgColor ?? 'transparent' }}"
>
    <x-public::block.wrapper
        :spacing-horizontal="$spacingHorizontal ?? null"
        :spacing-vertical="$spacingVertical ?? null"
    >
        <div class="nv-stats-wrapper">
            @if (filled($heading) || filled($description))
                <div class="nv-stats-content-wrapper mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                    @if (filled($heading))
                        <x-public::h2>
                            {{ $heading }}
                        </x-public::h2>
                    @endif

                    <div
                        @class([
                            'nv-stats-wrapper flex flex-col gap-x-8 gap-y-20 lg:flex-row',
                            'mt-6' => filled($heading),
                        ])
                    >
                        @if (filled($description))
                            <div class="nv-stats-content-ctn lg:w-full lg:max-w-2xl lg:flex-auto">
                                <x-public::lead markdown>
                                    {{ $description }}
                                </x-public::lead>
                            </div>
                        @endif

                        <div class="nv-stats-ctn @2xl:flex @2xl:flex-auto @2xl:justify-center">
                            <dl class="space-y-8">
                                @foreach (['language', 'sex', 'violence'] as $ratingType)
                                    @php($rating = settings("ratings.{$ratingType}"))

                                    <div class="flex items-center gap-x-3">
                                        <dd
                                            class="w-12 text-center font-[family-name:--font-header] text-5xl font-semibold tracking-tight text-gray-900 dark:text-white"
                                        >
                                            {{ $rating->rating }}
                                        </dd>
                                        <dt class="text-sm/6 text-gray-600 dark:text-white/60">
                                            <p class="font-semibold dark:text-white">{{ ucfirst($ratingType) }}</p>
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
    </x-public::block.wrapper>
</div>
