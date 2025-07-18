@use('Nova\Pages\Enums\BoxShadow')
@use('Nova\Pages\Enums\ButtonSize')
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
                <x-public::block.button :$button>
                    {{ data_get($button, 'text') }}
                </x-public::block.button>
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
