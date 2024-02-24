<div
    class="nv-content relative isolate overflow-hidden"
    @isset($backgroundColor)
        style="background-color:{{ $backgroundColor }}"
    @endisset
>
    <div class="nv-content-wrapper relative z-10 mx-auto max-w-7xl px-6 py-12 sm:py-16 lg:px-8">
        <div
            @class([
                'prose prose-lg max-w-none font-[family-name:--font-body]',
                'prose-h1:font-[family-name:--font-header]',
                'prose-h2:font-[family-name:--font-header]',
                'prose-h3:font-[family-name:--font-header]',
                'prose-h4:font-[family-name:--font-header]',
                'prose-invert' => $dark,
            ])
        >
            {!! tiptap_converter()->asHTML($content ?? ['content' => null]) !!}
        </div>
    </div>
</div>
