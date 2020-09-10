@props([
    'countWords' => true,
    'initialValue' => '',
    'name',
])

<div x-data="AlpineComponents.wordCount()" x-init="init()">
    <input id="content" name="{{ $name }}" value="{{ $initialValue }}" type="hidden">

    <trix-editor
        x-ref="editor"
        @if ($countWords) x-on:trix-change="refreshCount($event)" @endif
        input="content"
        class="trix-content relative w-full min-h-56 bg-transparent py-2 px-3 rounded-md border border-gray-200 bg-gray-50 shadow-sm transition ease-in-out duration-200 focus:border-blue-300 focus:bg-white focus:shadow-outline-blue">
    </trix-editor>

    @if ($countWords)
        <div class="mt-2 ml-0.5 text-sm text-gray-700">
            Word count: <span x-text="count"></span>
        </div>
    @endif
</div>

@push('scripts')
    <script src="https://unpkg.com/trix@1.2.3/dist/trix.js"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/trix@1.2.3/dist/trix.css">
@endpush