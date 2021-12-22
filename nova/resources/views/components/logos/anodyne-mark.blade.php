@props([
    'color' => '[#f99c26]',
    'gradientStart' => '[#f2634c]',
    'gradientStop' => '[#f99c26]',
    'gradient' => false,
    'id' => Illuminate\Support\Str::random(8),
])

@if ($gradient)
    <svg viewBox="0 0 408 350" fill="none" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}><path fill-rule="evenodd" clip-rule="evenodd" d="M121.396 349.947l-42.179-69.978L243.141.052h-81.962L.61 279.969l39.304 69.978h81.482zm211.854 0l-40.262-74.772h-94.903l46.973-90.109-38.345-71.897-91.069 168.717 39.303 68.061H333.25zM223.968 82.494l33.552-62.31 149.87 260.447-38.991 69.316L223.968 82.494z" fill="url(#prefix__paint{{ $id }}_linear)"/><defs><linearGradient id="prefix__paint{{ $id }}_linear" x1=".61" y1="174.999" x2="407.39" y2="174.999" gradientUnits="userSpaceOnUse"><stop stop-color="currentColor" class="text-{{ $gradientStart }}"/><stop offset="1" stop-color="currentColor" class="text-{{ $gradientStop }}"/></linearGradient></defs></svg>
@else
    <svg viewBox="0 0 90 78" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" {{ $attributes }}><defs><path d="M35.48,1.42108547e-14 L-7.10542736e-15,61.852 L8.685,77.316 L26.69,77.316 L17.37,61.852 L53.591,1.42108547e-14 L35.48,1.42108547e-14 Z M49.355,18.217 L81.27,77.316 L89.885,61.999 L56.769,4.448 L49.355,18.217 Z M25.418,62.276 L34.103,77.316 L73.503,77.316 L64.606,60.794 L43.635,60.794 L54.015,40.882 L45.541,24.995 L25.418,62.276 Z" id="path-1"></path></defs><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><mask id="mask-2" fill="white"><use xlink:href="#path-1"></use></mask><use id="mark" fill="currentColor" class="text-{{ $color }}" xlink:href="#path-1"></use></g></svg>
@endif