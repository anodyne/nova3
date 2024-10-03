<x-dynamic-component :component="$meta->layout">
    <div class="nova-basic-page-content">
        {!! scribble($page->published_blocks ?? ['content' => null])->toHtml() !!}
    </div>
</x-dynamic-component>
