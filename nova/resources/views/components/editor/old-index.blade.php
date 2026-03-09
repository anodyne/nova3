@props([
    'value' => '',
    'fieldName' => 'editor-content',
])

{{-- format-ignore-start --}}
<div
    x-data="tiptap(
        @if ($attributes->hasStartsWith('wire:model'))
            $wire.entangle('{{ $attributes->wire('model')->value() }}').live
        @else
            @js($value)
        @endif
    )"
    x-init="() => init($refs.editor)"
    {{ $attributes->whereDoesntStartWith('wire:model') }}
    data-slot="control"
>
    <div
        class="group relative flex w-full flex-col overflow-hidden rounded-lg border border-gray-300 bg-white shadow-sm transition focus-within:border-primary-600 focus-within:ring-1 focus-within:ring-primary-600 dark:border-gray-700 dark:bg-gray-800 dark:focus-within:border-primary-700 dark:focus-within:ring-1 dark:focus-within:ring-primary-700"
    >
        <div x-show="!codeView" wire:ignore>
            <nav
                class="menu flex flex-wrap items-center divide-x divide-gray-950/5 border-b border-gray-950/5 bg-gray-50 px-3 py-1.5 dark:divide-white/5 dark:border-white/5 dark:bg-gray-900/50"
            >
                <div class="my-1 flex items-center space-x-3 pr-3 md:my-0 md:space-x-2">
                    <x-editor.button.bold></x-editor.button.bold>
                    <x-editor.button.italic></x-editor.button.italic>
                    <x-editor.button.underline></x-editor.button.underline>
                </div>

                <div class="my-1 flex items-center space-x-3 px-3 md:my-0 md:space-x-2">
                    <x-editor.button.h1></x-editor.button.h1>
                    <x-editor.button.h2></x-editor.button.h2>
                    <x-editor.button.h3></x-editor.button.h3>
                    <x-editor.button.p></x-editor.button.p>
                </div>

                <div class="my-1 flex items-center space-x-3 px-3 md:my-0 md:space-x-2">
                    <x-editor.button.ul></x-editor.button.ul>
                    <x-editor.button.ol></x-editor.button.ol>
                    <x-editor.button.link></x-editor.button.link>
                    <x-editor.button.unlink x-show="window.editor.isActive('link', updatedAt)" x-cloak></x-editor.button.unlink>
                </div>

                <div class="my-1 flex items-center space-x-3 px-3 md:my-0 md:space-x-2">
                    <x-editor.button.align-left></x-editor.button.align-left>
                    <x-editor.button.align-center></x-editor.button.align-center>
                    <x-editor.button.align-right></x-editor.button.align-right>
                </div>

                <div class="my-1 flex items-center space-x-3 px-3 md:my-0 md:space-x-2">
                    <x-editor.button.blockquote></x-editor.button.blockquote>
                    <x-editor.button.hr></x-editor.button.hr>
                </div>

                <div class="my-1 flex items-center space-x-3 pl-3 md:my-0 md:space-x-2">
                    <x-editor.button.code-view></x-editor.button.code-view>
                </div>
            </nav>

            <div x-ref="editor"></div>
        </div>

        <div x-show="codeView">
            <nav
                class="menu flex items-center space-x-3 border-b border-gray-200 bg-gray-50 px-3 py-2 dark:border-gray-700 dark:bg-gray-900/50"
                x-show="codeView"
            >
                <button
                    type="button"
                    class="h-5 text-sm font-medium leading-0 text-gray-400 transition hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400"
                    x-on:click="
                        window.editor.commands.setContent(content);
                        codeView = false;
                    "
                >
                    Back to editor
                </button>
            </nav>
        </div>

        <textarea
            name="{{ $fieldName }}"
            class="w-full appearance-none border-none bg-transparent px-4 py-4 font-mono leading-relaxed focus:outline-none focus:ring-0"
            x-bind:class="{ 'hidden': !codeView }"
            rows="20"
            x-model="content"
        ></textarea>
    </div>

    <div class="px-2 py-2.5 text-sm text-gray-500 dark:text-gray-400">
        <span x-text="wordCount"></span>
    </div>
</div>
{{-- format-ignore-end --}}

@push('styles')
    @once
        <link rel="stylesheet" href="{{ asset('dist/css/tiptap.css') }}" />
    @endonce
@endpush
