@props([
    'base',
    'overlay' => false,
])

<div class="relative">
    <img src="{{ asset('ranks/base/' . $base) }}" alt="">
</div>