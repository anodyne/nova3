<div
    @class([
        '@container',
        'nv-stats nv-stats-simple',
        'dark' => $dark,
    ])
    style="--bgColor: {{ $bgColor ?? 'transparent' }}"
>
    <x-public::block.wrapper
        :spacing-horizontal="$spacingHorizontal ?? null"
        :spacing-vertical="$spacingVertical ?? null"
    >
        <div class="nv-stats-wrapper @xs:px-6 @lg:px-8 relative z-10 mx-auto max-w-7xl">
            @if (filled($heading) || filled($description))
                <div
                    @class([
                        'nv-stats-content-wrapper max-w-2xl',
                        'mx-auto' => $headerOrientation === 'center',
                        'ml-auto' => $headerOrientation === 'right',
                    ])
                >
                    <div
                        @class([
                            'nv-stats-ctn',
                            'text-center' => $headerOrientation === 'center',
                            'text-right' => $headerOrientation === 'right',
                        ])
                    >
                        @if (filled($heading))
                            <x-public::h2>{{ $heading }}</x-public::h2>
                        @endif

                        @if (filled($description))
                            <x-public::lead
                                @class([
                                    'mt-4' => filled($heading),
                                ])
                                markdown
                            >
                                {{ $description }}
                            </x-public::lead>
                        @endif
                    </div>
                </div>
            @endif

            <dl
                @class([
                    'grid gap-x-8 gap-y-16 text-center @xs:grid-cols-1 @lg:grid-cols-2',
                    '@4xl:grid-cols-2' => count($stats) === 2,
                    '@4xl:grid-cols-3' => count($stats) === 3,
                    '@4xl:grid-cols-4' => count($stats) === 4,
                    'mt-16' => filled($heading) || filled($description),
                ])
            >
                @foreach ($stats as $stat)
                    <div class="nv-stat-ctn mx-auto flex max-w-xs flex-col gap-y-4">
                        <dt class="nv-stat-heading text-base/7 text-gray-600 dark:text-gray-300">
                            {{ $stat->heading }}
                        </dt>

                        <dd
                            class="nv-stat-value order-first font-[family-name:--font-header] text-3xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-5xl"
                        >
                            <livewire:pages-stat-widget :identifier="$stat->stat" wire:key="{{ $stat->stat }}" />
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </x-public::block.wrapper>
</div>
