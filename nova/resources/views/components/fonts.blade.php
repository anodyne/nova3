@props([
    'section' => 'admin',
])

@php
    if ($section === 'admin') {
        $fonts = settings('appearance.adminFonts');
    } else {
        $fonts = app('nova.theme')?->getModel()?->settings?->fonts;
    }
@endphp

{!! $fonts?->getFontHtml() !!}
<style>
    :root {
        --font-header: '{{ $fonts?->headerFamily ?? 'Inter' }}';
        --font-body: '{{ $fonts?->bodyFamily ?? 'Inter' }}';
    }
</style>
