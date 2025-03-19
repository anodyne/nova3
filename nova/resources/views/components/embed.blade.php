@props(['url'])

@use('Cohensive\OEmbed\Facades\OEmbed')

<div
    class="relative w-full max-w-full overflow-hidden rounded-xl [&>embed]:aspect-video [&>embed]:w-full [&>iframe]:aspect-video [&>iframe]:w-full [&>object]:aspect-video [&>object]:w-full"
>
    {!! OEmbed::get($url)?->html() ?? 'Embed could not be rendered' !!}
</div>
