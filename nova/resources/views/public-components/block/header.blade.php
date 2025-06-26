@use('Nova\Pages\Enums\BoxShadow')
@use('Nova\Pages\Enums\CalloutType')
@use('Nova\Pages\Enums\Radius')
@use('Nova\Pages\Enums\TextShadow')

@props([
    'orientation' => 'left',
    'heading' => null,
    'message' => null,
    'callout' => null,
])

@aware([
    'leading',
    'trailing',
])

@php
    $headingTextShadow = TextShadow::tryFrom(data_get($heading, 'shadow') ?? 'none');
    $messageTextShadow = TextShadow::tryFrom(data_get($message, 'shadow') ?? 'none');

    $calloutType = CalloutType::tryFrom(data_get($callout, 'type') ?? 'text');
    $calloutRadius = Radius::tryFrom(data_get($callout, 'radius') ?? 'none');
    $calloutShadow = BoxShadow::tryFrom(data_get($callout, 'shadow') ?? 'none');
@endphp

<div
    {{
        $attributes->class([
            'nv-header-wrapper relative flex',
            'content-end justify-end' => $orientation === 'right',
        ])
    }}
    style="
        --content-heading-color: {{ data_get($heading, 'color') }};
        --content-message-color: {{ data_get($message, 'color') }};
    "
>
    <div
        @class([
            'nv-header-ctn',
            'mx-auto @lg:text-center' => $orientation === 'center',
            '@lg:text-right' => $orientation === 'right',
        ])
    >
        @isset($leading)
            {{ $leading }}
        @endisset

        @if (filled($callout))
            <div
                @class([
                    'nv-callout-ctn',
                    'mb-6' => isset($heading['text']),
                    '@xs:mt-24 @lg:mt-32 @2xl:mt-16' => $orientation !== null && $orientation === 'bottom',
                ])
                style="
                    --content-callout-text-color: {{ data_get($callout, 'color') }};
                    --content-callout-bg-color: {{ data_get($callout, 'bg.color') }};
                    --content-callout-border-color: {{ data_get($callout, 'border.color') }};
                "
            >
                <a class="nv-callout inline-flex space-x-6 transition" href="{{ data_get($callout, 'url') ?? '#' }}">
                    <span
                        @class([
                            'flex items-center gap-1.5 text-sm/6 font-semibold text-[--content-callout-text-color]',
                            'bg-[--content-callout-bg-color] px-3 py-1 ring-1 ring-[--content-callout-border-color]' => $calloutType === CalloutType::Badge,
                            $calloutRadius->getTailwindClasses() => $calloutType === CalloutType::Badge,
                            $calloutShadow->getTailwindClasses() => $calloutType === CalloutType::Badge,
                        ])
                    >
                        <span>{{ data_get($callout, 'text') }}</span>

                        @if (data_get($callout, 'decoration') === 'arrow')
                            <span class="text-base/6" aria-hidden="true">&rarr;</span>
                        @endif

                        @if (data_get($callout, 'decoration') === 'single-chevron')
                            <span class="text-base/6" aria-hidden="true">&rsaquo;</span>
                        @endif

                        @if (data_get($callout, 'decoration') === 'double-chevron')
                            <span class="text-base/6" aria-hidden="true">&raquo;</span>
                        @endif
                    </span>
                </a>
            </div>
        @endif

        @if (filled($heading))
            <h1
                @class([
                    'font-[family-name:--font-header] font-bold tracking-tight @xs:text-4xl @md:text-6xl',
                    'text-[--content-heading-color]',
                    $headingTextShadow->getTailwindClasses(),
                ])
            >
                {{ data_get($heading, 'text') }}
            </h1>
        @endif

        @if (filled($message))
            <x-public::lead
                @class([
                    'mt-6' => filled($heading),
                    'text-[--content-message-color]',
                    $messageTextShadow->getTailwindClasses(),
                ])
                markdown
            >
                {{ data_get($message, 'text') }}
            </x-public::lead>
        @endif

        @isset($trailing)
            {{ $trailing }}
        @endisset
    </div>
</div>
