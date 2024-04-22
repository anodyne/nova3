<div @class([
    'not-prose',
    'dark' => $dark,
]) style="--bgColor: {{ $bgColor ?? 'transparent' }}">
    <div class="mx-auto max-w-7xl bg-[--bgColor] px-8 py-8 font-[family-name:Flow_Circular]">
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
                        'mx-auto text-center' => $headerOrientation === 'center',
                        'text-right' => $headerOrientation === 'right',
                    ])
                >
                    @if (filled($heading))
                        <x-public::preview.h2>Heading</x-public::preview.h2>
                    @endif

                    @if (filled($description))
                        <x-public::preview.lead
                            @class([
                                'mt-6' => filled($heading),
                            ])
                            markdown
                        ></x-public::preview.lead>
                    @endif
                </div>
            </div>

            <div
                @class([
                    'nv-ratings-ctn grid grid-cols-3 gap-8',
                    'mt-10' => filled($heading) || filled($description),
                ])
            >
                @foreach (['language', 'sex', 'violence'] as $index => $ratingType)
                    <div class="nv-ratings-grid-item-rating-wrapper flex items-center gap-x-3">
                        <div
                            @class([
                                'nv-ratings-grid-item flex h-12 w-12 items-center justify-center rounded-xl font-[family-name:--font-header] text-4xl font-bold ring-1 ring-inset',
                                match ($index) {
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
                            {{ $index }}
                        </div>

                        <div class="nv-ratings-grid-item-content text-sm/5">
                            <p class="nv-ratings-grid-item-type font-semibold text-gray-600 dark:text-gray-400">
                                {{ ucfirst($ratingType) }}
                            </p>
                            <p class="nv-ratings-grid-item-description text-gray-500">Lorem ipsum dolor amet</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
