@props([
    'section' => 'admin',
])

@use('Nova\Settings\Data\FontFamilies')

@php
    $fonts = match ($section) {
        'admin' => settings('appearance.adminFonts'),
        'setup' => FontFamilies::from(
            headerProvider: 'local',
            headerFamily: 'Inter',
            bodyProvider: 'local',
            bodyFamily: 'Inter'
        ),
        default => app('nova.theme')?->getModel()?->settings?->fonts,
    };
@endphp

{!! $fonts?->getFontHtml() !!}
<style>
    :root {
        --font-header: '{{ $fonts?->headerFamily ?? 'Inter' }}';
        --font-body: '{{ $fonts?->bodyFamily ?? 'Inter' }}';
        --font-mono: '{{ $fonts?->monoFamily ?? 'Monaspace Neon' }}';
    }
</style>
