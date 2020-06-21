@props(['rank'])

<div class="rank">
    @isset($rank->overlay_image)
        <div class="rank-overlay" style="background-image:url({{ asset('ranks/overlay/' . $rank->overlay_image) }})"></div>
    @endisset
    <div class="rank-base" style="background-image:url({{ asset('ranks/base/' . $rank->base_image) }})"></div>
</div>
