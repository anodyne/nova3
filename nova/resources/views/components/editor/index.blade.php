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
>
    <div
        class="group relative flex w-full flex-col overflow-hidden rounded-md border border-gray-300 bg-white shadow-sm transition focus-within:border-primary-600 focus-within:ring-1 focus-within:ring-primary-600 dark:border-gray-700 dark:bg-gray-800 dark:focus-within:border-primary-700 dark:focus-within:ring-1 dark:focus-within:ring-primary-700"
    >
        <div x-show="!codeView" wire:ignore>
            <nav
                class="menu flex flex-wrap items-center divide-x divide-gray-100 border-b border-gray-200 bg-gray-50 px-3 py-1.5 dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-900/50"
            >
                <div class="my-1 flex items-center space-x-3 pr-3 md:my-0 md:space-x-2">
                    <x-button.editor-tools.bold></x-button.editor-tools.bold>
                    <x-button.editor-tools.italic></x-button.editor-tools.italic>
                    <x-button.editor-tools.underline></x-button.editor-tools.underline>
                </div>

                <div class="my-1 flex items-center space-x-3 px-3 md:my-0 md:space-x-2">
                    <x-button.editor-tools.h1></x-button.editor-tools.h1>
                    <x-button.editor-tools.h2></x-button.editor-tools.h2>
                    <x-button.editor-tools.h3></x-button.editor-tools.h3>
                    <x-button.editor-tools.p></x-button.editor-tools.p>
                </div>

                <div class="my-1 flex items-center space-x-3 px-3 md:my-0 md:space-x-2">
                    <x-button.editor-tools.ul></x-button.editor-tools.ul>
                    <x-button.editor-tools.ol></x-button.editor-tools.ol>
                    <x-button.editor-tools.link></x-button.editor-tools.link>
                    <x-button.editor-tools.unlink x-show="window.editor.isActive('link', updatedAt)" x-cloak></x-button.editor-tools.unlink>
                </div>

                <div class="my-1 flex items-center space-x-3 px-3 md:my-0 md:space-x-2">
                    <x-button.editor-tools.align-left></x-button.editor-tools.align-left>
                    <x-button.editor-tools.align-center></x-button.editor-tools.align-center>
                    <x-button.editor-tools.align-right></x-button.editor-tools.align-right>
                </div>

                <div class="my-1 flex items-center space-x-3 px-3 md:my-0 md:space-x-2">
                    <x-button.editor-tools.blockquote></x-button.editor-tools.blockquote>
                    <x-button.editor-tools.hr></x-button.editor-tools.hr>
                </div>

                <div class="my-1 flex items-center space-x-3 pl-3 md:my-0 md:space-x-2">
                    <x-button.editor-tools.code-view></x-button.editor-tools.code-view>
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
