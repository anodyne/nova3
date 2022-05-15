@props([
    'status',
])

<span aria-label="{{ $status->displayName() }}" class="{{ $status->bgColor() }} shrink-0 inline-block h-2 w-2 rounded-full"></span>
