@props([
    'section' => 'admin',
])

@php($fonts = settings("appearance.{$section}Fonts"))

{!! $fonts?->getFontHtml() !!}
<style>
    :root {
        --font-header: '{{ $fonts?->headerFamily ?? 'Inter' }}';
        --font-body: '{{ $fonts?->bodyFamily ?? 'Inter' }}';
    }
</style>
