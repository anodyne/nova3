@props(['button'])

@use('Nova\Pages\Enums\BoxShadow')
@use('Nova\Pages\Enums\ButtonDecoration')
@use('Nova\Pages\Enums\ButtonSize')
@use('Nova\Pages\Enums\Radius')

@php
    $buttonDecoration = ButtonDecoration::tryFrom(data_get($button, 'decoration') ?? 'none');
    $buttonSize = ButtonSize::tryFrom(data_get($button, 'size') ?? 'text');
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
            'flex items-center gap-1.5 bg-(--bg-color) text-(--text-color) transition hover:brightness-110',
            'ring-1 ring-(--border-color)' => data_get($button, 'border-style') !== 'none',
            'ring-inset' => data_get($button, 'border-style') === 'inner',
            $buttonSize?->getTailwindClasses(),
            $radius?->getTailwindClasses(),
            $shadow?->getTailwindClasses(),
        ])
    >
        <span>{{ $slot }}</span>

        @if ($buttonDecoration !== ButtonDecoration::None)
            <span class="text-base/6" aria-hidden="true">{!! $buttonDecoration->getHtml() !!}</span>
        @endif
    </a>
</div>
