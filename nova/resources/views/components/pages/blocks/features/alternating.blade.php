@use('Nova\Pages\Enums\BoxShadow')
@use('Nova\Pages\Enums\Radius')

@php
    $imageShadow = BoxShadow::tryFrom(data_get($block, 'image.shadow') ?? 'none');
    $imageRadius = Radius::tryFrom(data_get($block, 'image.radius') ?? 'none');
@endphp

<x-public::block.container :$container :$content :$block class="nv-features nv-features-alternating">
    <div class="@xs:mt-16 @lg:mt-20 space-y-24 @2xl:mt-24">
        @foreach (data_get($block, 'features') as $feature)
            @php
                $image = collect(data_get($feature, 'image'))->flatten()->toArray();
            @endphp

            <div class="flex gap-x-16">
                <div
                    @class([
                        'max-w-xl',
                        'order-last' => $loop->even,
                    ])
                >
                    @if (data_get($feature, 'content'))
                        <div
                            @class([
                                'prose prose-lg max-w-none font-(family-name:--font-body)',
                                'prose-h1:font-(family-name:--font-header)',
                                'prose-h2:font-(family-name:--font-header)',
                                'prose-h3:font-(family-name:--font-header)',
                                'prose-h4:font-(family-name:--font-header)',
                                'dark:prose-invert',
                            ])
                        >
                            {!! data_get($feature, 'content') !!}
                        </div>
                    @endif
                </div>

                <div
                    @class([
                        'flex-1',
                        'order-first' => $loop->even,
                    ])
                >
                    @if ($image)
                        <img
                            src="{{ Storage::disk('media-pages')->url($image[0]) }}"
                            alt=""
                            width="2432"
                            height="1442"
                            @class([
                                'nv-hero-image w-[76rem]',
                                $imageRadius?->getTailwindClasses(),
                                $imageShadow?->getTailwindClasses(),
                            ])
                        />
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</x-public::block.container>
