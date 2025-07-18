@php
    $dark = data_get($block, 'dark');
    $stats = data_get($block, 'stats') ?? [];
@endphp

<x-public::block.container
    :$container
    :$content
    :$block
    class="nv-stats nv-stats-split"
    inner-class="grid grid-cols-2 gap-8"
>
    <x-slot name="afterHeader">
        <div class="nv-stats-stat-wrapper @2xl:flex @2xl:flex-auto @2xl:justify-center">
            <dl class="nv-stats-stat-ctn @xs:w-64 space-y-8 @2xl:w-80">
                @foreach ($stats as $stat)
                    <div
                        class="flex flex-col-reverse gap-y-4"
                        style="
                            --stat-stat-color: {{ data_get($block, 'appearance.stat-color') }};
                            --stat-label-color: {{ data_get($block, 'appearance.label-color') }};
                        "
                    >
                        <dt class="text-base/7 text-[--stat-label-color]">
                            {{ data_get($stat, 'heading') }}
                        </dt>
                        <dd
                            class="font-[family-name:--font-header] text-5xl font-semibold tracking-tight text-[--stat-stat-color]"
                        >
                            <livewire:pages-stat-widget
                                :identifier="data_get($stat, 'stat')"
                                wire:key="split-{{ data_get($stat, 'stat') }}"
                            />
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </x-slot>
</x-public::block.container>
