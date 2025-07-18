<x-dynamic-component :component="$meta->layout">
    <div class="@container nova-basic-page-content">
        @if (filled($meta->pageHeading) || filled($meta->pageSubheading) || filled($meta->pageIntro))
            <div class="page-header">
                @if (filled($meta->pageHeading))
                    <x-public::h1>{{ $meta->pageHeading }}</x-public::h1>
                @endif

                @if (filled($meta->pageSubheading))
                    <p
                        @class([
                            'subheading',
                            'mt-2' => filled($meta->pageHeading),
                        ])
                    >
                        {{ $meta->pageSubheading }}
                    </p>
                @endif

                @if (filled($meta->pageIntro))
                    <x-public::lead
                        @class([
                            'intro mb-8',
                            'mt-4' => filled($meta->pageSubheading),
                            'mt-6' => blank($meta->pageSubheading) && filled($meta->pageHeading),
                        ])
                    >
                        {{ $meta->pageIntro }}
                    </x-public::lead>
                @endif
            </div>
        @endif

        {!! $page->rendered_block_content !!}
    </div>
</x-dynamic-component>
