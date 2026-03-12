@props([
    'admin' => false,
    'form' => null,
    'static' => false,
    'values' => [],
])

<div class="space-y-8">
    {{ $slot }}
</div>
