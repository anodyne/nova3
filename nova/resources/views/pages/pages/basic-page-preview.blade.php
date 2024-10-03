<x-public-layout>
    <div class="nova-basic-page-content">
        {!! scribble($page->blocks ?? ['content' => null])->toHtml() !!}
    </div>
</x-public-layout>
