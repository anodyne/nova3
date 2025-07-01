@php
    $dark = data_get($block, 'dark');
    $stats = data_get($block, 'stats') ?? [];
@endphp

<x-public::block.container :$container :$content :$block class="nv-stats nv-stats-simple">
    <dl
        @class([
            'nv-stats-stat-wrapper grid gap-x-8 gap-y-16 text-center @xs:grid-cols-1 @lg:grid-cols-2',
            '@4xl:grid-cols-2' => count($stats) === 2,
            '@4xl:grid-cols-3' => count($stats) === 3,
            '@4xl:grid-cols-4' => count($stats) === 4,
            'mt-16' => filled($content, 'heading.text') || filled($content, 'message.text') || filled($content, 'callout.text'),
        ])
    >
        @foreach ($stats as $stat)
            <div
                class="nv-stats-stat-ctn mx-auto flex max-w-xs flex-col gap-y-4"
                style="
                    --stat-stat-color: {{ data_get($block, 'appearance.stat-color') }};
                    --stat-label-color: {{ data_get($block, 'appearance.label-color') }};
                "
            >
                <dt class="nv-stat-heading text-base/7 text-[--stat-label-color]">
                    {{ data_get($stat, 'heading') }}
                </dt>

                <dd
                    class="nv-stat-value order-first font-[family-name:--font-header] text-3xl font-semibold tracking-tight text-[--stat-stat-color] sm:text-5xl"
                >
                    <livewire:pages-stat-widget
                        :identifier="data_get($stat, 'stat')"
                        wire:key="simple-{{ data_get($stat, 'stat') }}"
                    />
                </dd>
            </div>
        @endforeach
    </dl>
</x-public::block.container>
