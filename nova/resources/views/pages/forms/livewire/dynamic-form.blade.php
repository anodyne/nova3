@props([
    'admin' => false,
])

<div class="space-y-8">
    {!! scribble($fields ?? ['content' => null])->toHtml() !!}
</div>
