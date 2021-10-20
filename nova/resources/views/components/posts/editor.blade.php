<div
    x-data="tipTap(@entangle($attributes->wire('model')).defer)"
    x-init="() => init($refs.editor)"
    @click.away="inFocus = false"
    wire:ignore
    {{ $attributes->whereDoesntStartWith('wire:model') }}
>
    <template x-if="editor">
        <x-posts.toolbar />

        <div x-ref="editor"></div>
    </template>
</div>

@push('styles')
    @once
        <link rel="stylesheet" href="{{ asset('dist/css/tiptap.css') }}">
    @endonce
@endpush