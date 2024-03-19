<div @class([
    'not-prose',
    'dark' => $dark,
]) style="--bgColor: {{ $bgColor ?? 'transparent' }}">
    <div class="mx-auto max-w-7xl bg-[--bgColor] px-8 py-8 font-[family-name:Flow_Circular]">
        <div class="nv-stats-wrapper">
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
                            <x-public::preview.h2>
                                {{ $heading }}
                            </x-public::preview.h2>
                        @endif

                        @if (filled($description))
                            <x-public::preview.lead
                                @class([
                                    'mt-4' => filled($heading),
                                ])
                                markdown
                            >
                                {{ $description }}
                            </x-public::preview.lead>
                        @endif
                    </div>
                </div>
            @endif

            <dl
                @class([
                    'grid gap-x-8 gap-y-16 text-center',
                    'grid-cols-2' => count($stats) === 2,
                    'grid-cols-3' => count($stats) === 3,
                    'grid-cols-4' => count($stats) === 4,
                    'mt-16' => filled($heading) || filled($description),
                ])
            >
                @foreach ($stats as $stat)
                    <div class="nv-stat-ctn mx-auto flex flex-col gap-y-4">
                        <dt class="nv-stat-heading text-base/7 text-gray-600 dark:text-gray-300">Heading</dt>

                        <dd
                            class="nv-stat-value order-first text-center text-5xl font-semibold tracking-tight text-gray-900 dark:text-white"
                        >
                            3
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
</div>
