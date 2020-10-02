@props([
    'content' => '{}',
    'placeholder' => '',
])

<div
    x-data="AlpineComponents.editor({ placeholder: '{{ $placeholder }}' })"
    x-init="init($dispatch)"
    wire:ignore
    {{ $attributes }}
>
    <div id="editorjs"></div>
</div>