@props([
    'calloutColor' => 'Gray',
])

@php
    $color = constant('Nova\Foundation\Colors\Color::'.$calloutColor);
@endphp

<a
    class="nv-callout inline-flex space-x-6 transition"
    style="
        --nv-page-callout-color50: rgb({{ $color[50] }});
        --nv-page-callout-color100: rgb({{ $color[100] }});
        --nv-page-callout-color200: rgb({{ $color[200] }});
        --nv-page-callout-color300: rgb({{ $color[300] }});
        --nv-page-callout-color700: rgb({{ $color[700] }});
        --nv-page-callout-color800: rgb({{ $color[800] }});
        --nv-page-callout-color900: rgb({{ $color[900] }});
        --nv-page-callout-color950: rgb({{ $color[950] }});
    "
    {{ $attributes }}
>
    <span
        class="rounded-full bg-[--nv-page-callout-color50] px-3 py-1 text-sm/6 font-semibold text-[--nv-page-callout-color700] ring-1 ring-inset ring-[--nv-page-callout-color200] hover:bg-[--nv-page-callout-color100] hover:ring-[--nv-page-callout-color300] dark:bg-[--nv-page-callout-color950] dark:text-[--nv-page-callout-color300] dark:ring-[--nv-page-callout-color800] dark:hover:bg-[--nv-page-callout-color900] dark:hover:ring-[--nv-page-callout-color700]"
    >
        {{ $slot }}
        <span aria-hidden="true">&rarr;</span>
    </span>
</a>
