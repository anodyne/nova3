@props([
    'base',
    'overlay' => false,
])

<div class="rank">
    <div class="rank-overlay" style="background-image:url({{ asset('ranks/overlay/' . $overlay) }})"></div>
    <div class="rank-base" style="background-image:url({{ asset('ranks/base/' . $base) }})"></div>
</div>
