@use('Nova\Pages\Enums\BoxShadow')
@use('Nova\Pages\Enums\Radius')

@php
    $mediaType = data_get($block, 'media.type');
    $orientation = data_get($block, 'media.orientation');

    $mediaShadow = BoxShadow::tryFrom(data_get($block, 'media.shadow') ?? 'none');
    $mediaRadius = Radius::tryFrom(data_get($block, 'media.radius') ?? 'none');

    $image = data_get($block, 'media.image');
    $imageSrc = is_array($image) ? last($image) : $image;

    $video = data_get($block, 'media.video');
@endphp

<x-public::block.container :$container :$content :$block class="nv-hero nv-hero-stacked" inner-class="flex flex-col">
    <x-slot name="trailing">
        <div
            @class([
                'relative mt-6 flex items-center gap-6',
                'justify-center' => data_get($content, 'orientation') === 'center',
                'flex-row-reverse' => data_get($content, 'orientation') === 'right',
            ])
        >
            @foreach (data_get($block, 'buttons') as $button)
                @php
                    $radius = Radius::tryFrom(data_get($button, 'radius') ?? 'none');
                    $shadow = BoxShadow::tryFrom(data_get($button, 'shadow') ?? 'none');
                @endphp

                <div
                    style="
                        --bg-color: {{ data_get($button, 'bg-color') }};
                        --text-color: {{ data_get($button, 'text-color') }};
                        --border-color: {{ data_get($button, 'border-color') }};
                    "
                >
                    <a
                        href="{{ data_get($button, 'url') }}"
                        target="{{ data_get($button, 'url-target') }}"
                        @class([
                            'flex items-center gap-1.5 px-3.5 py-2.5 text-sm/6 font-semibold transition hover:brightness-110',
                            'bg-[--bg-color] text-[--text-color]',
                            'ring-1 ring-[--border-color]' => data_get($button, 'border-style') !== 'none',
                            'ring-inset' => data_get($button, 'border-style') === 'inner',
                            $radius?->getTailwindClasses(),
                            $shadow?->getTailwindClasses(),
                        ])
                    >
                        <span>{{ data_get($button, 'text') }}</span>

                        @if (data_get($button, 'decoration') === 'arrow')
                            <span class="text-base/6" aria-hidden="true">&rarr;</span>
                        @endif

                        @if (data_get($button, 'decoration') === 'single-chevron')
                            <span class="text-base/6" aria-hidden="true">&rsaquo;</span>
                        @endif

                        @if (data_get($button, 'decoration') === 'double-chevron')
                            <span class="text-base/6" aria-hidden="true">&raquo;</span>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
    </x-slot>

    @if ($mediaType !== 'none')
        <div
            @class([
                'nv-hero-image-ctn flow-root',
                'order-none @xs:mt-16 @lg:mt-24' => isset($orientation) && $orientation === 'bottom',
                'order-first @xs:mb-16 @lg:mb-24' => isset($orientation) && $orientation === 'top',
            ])
        >
            @if (isset($imageSrc) && filled($imageSrc))
                <img
                    src="{{ Storage::disk('media-pages')->url($imageSrc) }}"
                    alt=""
                    width="2432"
                    height="1442"
                    @class([
                        'nv-hero-image ring-1 ring-gray-900/10',
                        $mediaShadow?->getTailwindClasses(),
                        $mediaRadius?->getTailwindClasses(),
                    ])
                />
            @endif

            @if (isset($video) && filled($video))
                <x-embed :url="$video"></x-embed>
            @endif
        </div>
    @endif
</x-public::block.container>
