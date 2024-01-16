@props([
    'section' => 'admin',
])

{!! nova()->getFontHtml() !!}
<style>
    :root {
        --font-family: {!! nova()->getFontFamily() !!};
        --font-header: {!! nova()->getHeaderFontFamily($section) !!};
        --font-body: {!! nova()->getBodyFontFamily($section) !!};
    }
</style>
