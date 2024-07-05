@props([
    'admin' => false,
    'form' => null,
    'static' => false,
    'values' => [],
])

<div class="prose space-y-8 dark:prose-invert">
    {{ $slot }}
</div>
