@props([
    'static' => false,
])

<div class="flex items-center rounded-full space-x-1 overflow-hidden text-sm font-semibold">
    @for ($r = 0; $r <= 3; $r++)
        @if ($static)
            <div class="flex-1 py-0.5 bg-gray-300 text-white text-center transition ease-in-out duration-150">
                {{ $r }} or &nbsp;
            </div>
        @else
            <a href="#" class="flex-1 py-0.5 bg-gray-300 hover:bg-gray-400 text-white text-center transition ease-in-out duration-150">
                {{ $r }} or &nbsp;
            </a>
        @endif
    @endfor
</div>