@props(['rank'])

<div class="rank">
    @if (filled($rank?->overlay_image))
        <div
            class="rank-overlay"
            style="background-image: url({{ asset('ranks/overlay/'.$rank->overlay_image) }})"
        ></div>
    @endif

    @if (filled($rank?->base_image))
        <div class="rank-base" style="background-image: url({{ asset('ranks/base/'.$rank->base_image) }})"></div>
    @endif
</div>
