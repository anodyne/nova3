@use('Nova\Pages\Enums\Spacing')
@use('Nova\Pages\Enums\MaxWidth')

@props([
    'container',
    'content',
    'block',
    'header' => null,
    'leading' => null,
    'trailing' => null,
    'wrapperClass' => null,
    'innerClass' => null,
    'headerClass' => null,
    'beforeContent' => null,
    'afterContent' => null,
    'beforeHeader' => null,
    'afterHeader' => null,
])

@php
    $width = MaxWidth::tryFrom(data_get($container, 'width', 'full'));
    $horizontalSpacing = Spacing::tryFrom(data_get($container, 'spacing.horizontal', 'none'));
    $verticalSpacing = Spacing::tryFrom(data_get($container, 'spacing.vertical', 'none'));

    $bgOption = data_get($container, 'bg.option');
    $hasBackgroundColor = filled($bgOption) && $bgOption === 'color';
@endphp

<div
    {{
        $attributes->class([
            'relative @container',
            $width->getTailwindClasses(),
            'mx-auto' => data_get($container, 'width') !== MaxWidth::Full,
            'bg-[--container-bg-color]' => $hasBackgroundColor,
        ])
    }}
    style="--container-bg-color: {{ data_get($container, 'bg.color', 'transparent') }}"
>
    <x-public::block.background-image :bg="data_get($container, 'bg')"></x-public::block.background-image>

    @if (isset($beforeContent))
        {{ $beforeContent }}
    @endif

    <div
        @class([
            $horizontalSpacing->getHorizontalTailwindClasses(),
            $verticalSpacing->getVerticalTailwindClasses(),
        ])
    >
        <x-public::block.content>
            {{ $slot }}
        </x-public::block.content>
    </div>

    @if (isset($afterContent))
        {{ $afterContent }}
    @endif
</div>
