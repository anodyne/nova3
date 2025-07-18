@use('Nova\Pages\Enums\ProseSize')

@php
    $hasHeaderContent = filled($content, 'heading.text') || filled($content, 'message.text') || filled($content, 'callout.text');

    $proseSize = ProseSize::tryFrom(data_get($block, 'text-size') ?? 'base');
@endphp

<x-public::block.container :$container :$content :$block class="nv-content">
    <div
        @class([
            'prose max-w-none text-[--prose-text-color]',
            $proseSize?->getTailwindClasses(),
            'mt-6' => $hasHeaderContent,
        ])
        style="--prose-text-color: {{ data_get($block, 'text-color') }}"
    >
        {!! data_get($block, 'content') !!}
    </div>
</x-public::block.container>
