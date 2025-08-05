@use('Nova\Pages\Enums\Blur')
@use('Nova\Pages\Enums\BoxShadow')
@use('Nova\Pages\Enums\MaxWidth')
@use('Nova\Pages\Enums\Radius')
@use('Nova\Pages\Enums\Spacing')

@aware([
    'container',
    'content',
    'block',
    'header',
    'leading',
    'trailing',
    'wrapperClass',
    'innerClass',
    'headerClass',
    'beforeHeader',
    'afterHeader',
])

@php
    $width = MaxWidth::tryFrom(data_get($content, 'width', 'full'));
    $horizontalSpacing = Spacing::tryFrom(data_get($content, 'spacing.horizontal', 'none'));
    $verticalSpacing = Spacing::tryFrom(data_get($content, 'spacing.vertical', 'none'));
    $blur = Blur::tryFrom(data_get($content, 'bg.blur', 'none'));

    $bgOption = data_get($content, 'bg.option');
    $hasBackgroundColor = filled($bgOption) && $bgOption === 'color';
    $hasBackgroundImage = filled($bgOption) && ! in_array($bgOption, ['color', 'transparent']);
    $hasBorder = data_get($content, 'border.enabled') == 'yes';
    $radius = Radius::tryFrom(data_get($content, 'radius') ?? 'none');
    $shadow = BoxShadow::tryFrom(data_get($content, 'shadow') ?? 'none');
@endphp

<div
    @class([
        'nv-content relative',
        $width->getTailwindClasses(),
        'mx-auto' => data_get($content, 'width') !== MaxWidth::Full,
        $wrapperClass => isset($wrapperClass),
    ])
    style="
        --content-bg-color: {{ data_get($content, 'bg.color') }};
        --content-border-color: {{ data_get($content, 'border.color') }};
    "
>
    <div
        @class([
            'relative',
            $horizontalSpacing->getHorizontalTailwindClasses(),
            $verticalSpacing->getVerticalTailwindClasses(),
            $radius?->getTailwindClasses(),
            $shadow?->getTailwindClasses(),
            $blur?->getTailwindClasses(),
            'border border-(--content-border-color)' => $hasBorder,
            'bg-(--content-bg-color)' => $hasBackgroundColor,
            'overflow-hidden' => $hasBackgroundImage,
            $innerClass => isset($innerClass),
        ])
    >
        <x-public::block.background-image :bg="data_get($content, 'bg')"></x-public::block.background-image>

        @if (isset($beforeHeader))
            {{ $beforeHeader }}
        @endif

        @if (isset($header))
            {{ $header }}
        @else
            <x-public::block.header
                :heading="data_get($content, 'heading')"
                :message="data_get($content, 'message')"
                :callout="data_get($content, 'callout')"
                :orientation="data_get($content, 'orientation')"
                @class([
                    $headerClass => isset($headerClass),
                ])
            ></x-public::block.header>
        @endif

        @if (isset($afterHeader))
            {{ $afterHeader }}
        @endif

        {{ $slot }}
    </div>
</div>
