<div
    @class([
        '@container',
        'nv-content',
        'dark' => $dark,
    ])
    style="--bgColor: {{ $bgColor ?? 'transparent' }}"
>
    <x-public::block.wrapper
        :spacing-horizontal="$spacingHorizontal ?? null"
        :spacing-vertical="$spacingVertical ?? null"
    >
        <div
            class="nv-content-wrapper prose prose-lg max-w-none font-[family-name:--font-body] dark:prose-invert prose-h1:font-[family-name:--font-header] prose-h2:font-[family-name:--font-header] prose-h3:font-[family-name:--font-header] prose-h4:font-[family-name:--font-header]"
        >
            {!! scribble($content ?? ['content' => null])->toHtml() !!}
        </div>
    </x-public::block.wrapper>
</div>
