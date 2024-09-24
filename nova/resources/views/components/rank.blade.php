@props(['rank'])

<div class="nv-rank-ctn grid h-10 w-36 shrink-0 overflow-hidden [grid-template-areas:'rank']">
    @if (filled($rank?->base_image))
        <div
            class="nv-rank-base-img h-10 w-36 bg-transparent [background-size:144px_40px] [grid-area:rank]"
            style="background-image: url({{ asset('ranks/base/'.$rank->base_image) }})"
        ></div>
    @endif

    @if (filled($rank?->overlay_image))
        <div
            class="nv-rank-overlay-img h-10 w-36 bg-transparent [background-size:144px_40px] [grid-area:rank]"
            style="background-image: url({{ asset('ranks/overlay/'.$rank->overlay_image) }})"
        ></div>
    @endif
</div>
