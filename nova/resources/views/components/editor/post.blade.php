<div
    x-data="setupEditor(
        @entangle($attributes->wire('model')).defer
    )"
    x-init="() => init($refs.editor)"
    @click.away="inFocus = false;"
    wire:ignore
    {{ $attributes->whereDoesntStartWith('wire:model') }}
>
    <x-editor.post-toolbar />

    <div x-ref="editor"></div>
</div>

@push('scripts')
    @once
        <script src="{{ asset('dist/js/editor-tiptap.js') }}"></script>
    @endonce
@endpush

@push('styles')
    @once
        <link rel="stylesheet" href="{{ asset('dist/css/tiptap.css') }}">
    @endonce
@endpush