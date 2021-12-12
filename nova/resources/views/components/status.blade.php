@props([
    'status',
])

<span aria-label="{{ $status->displayName() }}" class="bg-{{ $status->color() }}-9 shrink-0 inline-block h-2 w-2 rounded-full"></span>
