<div
    @class([
        '@container',
        'nv-stats nv-stats-split',
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
                <div class="nv-stats-content-wrapper @xs:mx-auto @xs:max-w-2xl @xl:mx-0 @xl:max-w-none">
                    @if (filled($heading))
                        <x-public::h2>{{ $heading }}</x-public::h2>
                    @endif

                    <div
                        @class([
                            'nv-stats-content-ctn flex gap-x-8 gap-y-20 @xs:flex-col @2xl:flex-row',
                            'mt-6' => filled($heading),
                        ])
                    >
                        @if (filled($description))
                            <div class="max-w-2xl">
                                <x-public::lead markdown>
                                    {{ $description }}
                                </x-public::lead>
                            </div>
                        @endif

                        <div class="nv-stats-stat-wrapper @2xl:flex @2xl:flex-auto @2xl:justify-center">
                            <dl class="nv-stats-stat-ctn @xs:w-64 space-y-8 @2xl:w-80">
                                @foreach ($stats as $stat)
                                    <div class="flex flex-col-reverse gap-y-4">
                                        <dt class="text-base/7 text-gray-600 dark:text-gray-300">
                                            {{ $stat->heading }}
                                        </dt>
                                        <dd
                                            class="font-[family-name:--font-header] text-5xl font-semibold tracking-tight text-gray-900 dark:text-white"
                                        >
                                            <livewire:pages-stat-widget
                                                :identifier="$stat->stat"
                                                wire:key="{{ $stat->stat }}"
                                            />
                                        </dd>
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
