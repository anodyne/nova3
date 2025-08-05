@use('Nova\Pages\Enums\BoxShadow')
@use('Nova\Pages\Enums\Radius')

@php
    $cardShadow = BoxShadow::tryFrom(data_get($block, 'card.shadow') ?? 'none');
    $cardRadius = Radius::tryFrom(data_get($block, 'card.radius') ?? 'none');
@endphp

<x-public::block.container :$container :$content :$block class="nv-features nv-features-cards">
    <div class="@xs:mt-16 @lg:mt-20 space-y-3 @2xl:mt-24">
        @foreach (data_get($block, 'rows') as $row)
            <div
                class="@xs:grid-cols-1 grid gap-3 @2xl:grid-cols-3"
                style="
                    --feature-heading-color: {{ data_get($block, 'heading-color') }};
                    --feature-description-color: {{ data_get($block, 'description-color') }};
                    --feature-card-color: {{ data_get($block, 'card.bg') }};
                    --feature-card-radius: {{ $cardRadius?->getRawValue() }};
                    --feature-card-border-color: {{ data_get($block, 'card.border.color') }};
                "
            >
                @foreach (data_get($row, 'columns') as $column)
                    @php
                        $image = collect(data_get($column, 'image'))->flatten()->toArray();
                    @endphp

                    <div
                        @class([
                            'flex flex-col bg-(--feature-card-color) ring-1 ring-(--feature-card-border-color)',
                            $cardRadius?->getTailwindClasses(),
                            $cardShadow?->getTailwindClasses(),
                            match (true) {
                                data_get($row, 'layout') === 'md-sm' && $loop->first => 'col-span-2',
                                data_get($row, 'layout') === 'md-sm' && $loop->last => 'col-span-1',
                                data_get($row, 'layout') === 'sm-md' && $loop->first => 'col-span-1',
                                data_get($row, 'layout') === 'sm-md' && $loop->last => 'col-span-2',
                                data_get($row, 'layout') === 'sm' => 'col-span-1',
                                default => 'col-span-3',
                            },
                        ])
                    >
                        <x-spacing class="flex-1" size="md">
                            @if ($heading = data_get($column, 'heading'))
                                <h3
                                    class="font-(family-name:--font-header) text-lg/8 font-semibold text-(--feature-heading-color)"
                                >
                                    {{ $heading }}
                                </h3>
                            @endif

                            @if ($description = data_get($column, 'description'))
                                <div
                                    @class([
                                        'space-y-6 text-base/7 text-(--feature-description-color)',
                                        'mt-1' => filled($heading),
                                    ])
                                >
                                    {!! str($description)->markdown() !!}
                                </div>
                            @endif
                        </x-spacing>

                        @if (isset($image[0]))
                            <img
                                src="{{ Storage::disk('media-pages')->url($image[0]) }}"
                                alt=""
                                @class([
                                    'mx-auto block h-56 w-[calc(100%-8px)] rounded-[calc(var(--feature-card-radius)-4px)] object-cover',
                                    'order-first mt-1' => data_get($block, 'card.image-orientation') === 'top',
                                    'mb-1' => data_get($block, 'card.image-orientation') === 'bottom',
                                    'h-48' => data_get($row, 'layout') !== 'lg',
                                    'h-96' => data_get($row, 'layout') === 'lg',
                                ])
                            />
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</x-public::block.container>
