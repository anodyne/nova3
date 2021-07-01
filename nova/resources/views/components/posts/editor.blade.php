<div
    x-data="tipTap(
        @entangle($attributes->wire('model')).defer,
        $refs.editor
    )"
    @click.away="inFocus = false;"
    wire:ignore
    {{ $attributes->whereDoesntStartWith('wire:model') }}
>
    <x-posts.toolbar />

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