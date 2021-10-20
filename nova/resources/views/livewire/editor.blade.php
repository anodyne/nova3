<div
    x-data="tipTap(@entangle('content'))"
    x-init="() => init($refs.editor)"
    @click.away="inFocus = false"
>
    <div class="group flex flex-col relative w-full rounded-md border border-gray-6 shadow-sm bg-gray-1 transition ease-in-out duration-200 focus-within:border-blue-7 focus-within:ring-1 focus-within:ring-blue-7 overflow-hidden">
        <div class="{{ $codeView ? 'hidden' : '' }}">
            <div wire:ignore>
                <template x-if="editor">
                    <nav class="menu flex items-center space-x-10 border-b border-gray-6 pt-2 pb-1 px-3 bg-gray-2">
                        <div class="space-x-2">
                            <button
                                type="button"
                                class="leading-0 transition duration-150"
                                :class="{ 'text-blue-9': isActive('bold', updatedAt), 'text-gray-9 hover:text-gray-11': !isActive('bold', updatedAt) }"
                                @click="toggleBold()"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5"><path fill="none" d="M0 0h24v24H0z"/><path d="M8 11h4.5a2.5 2.5 0 1 0 0-5H8v5zm10 4.5a4.5 4.5 0 0 1-4.5 4.5H6V4h6.5a4.5 4.5 0 0 1 3.256 7.606A4.498 4.498 0 0 1 18 15.5zM8 13v5h5.5a2.5 2.5 0 1 0 0-5H8z" fill="currentColor" /></svg>
                            </button>

                            <button
                                type="button"
                                class="leading-0 transition duration-150"
                                :class="{ 'text-blue-9': isActive('italic', updatedAt), 'text-gray-9 hover:text-gray-11': !isActive('italic', updatedAt) }"
                                @click="toggleItalic()"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5"><path fill="none" d="M0 0h24v24H0z"/><path d="M15 20H7v-2h2.927l2.116-12H9V4h8v2h-2.927l-2.116 12H15z" fill="currentColor"/></svg>
                            </button>

                            <button
                                type="button"
                                class="leading-0 transition duration-150"
                                :class="{ 'text-blue-9': isActive('underline', updatedAt), 'text-gray-9 hover:text-gray-11': !isActive('underline', updatedAt) }"
                                @click="toggleUnderline()"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5"><path fill="none" d="M0 0h24v24H0z"/><path d="M8 3v9a4 4 0 1 0 8 0V3h2v9a6 6 0 1 1-12 0V3h2zM4 20h16v2H4v-2z" fill="currentColor"/></svg>
                            </button>

                        </div>

                        <div class="space-x-2">
                            <button
                                type="button"
                                class="leading-0 transition duration-150"
                                :class="{ 'text-blue-9': isActive('heading', { level: 1 }, updatedAt), 'text-gray-9 hover:text-gray-11': !isActive('heading', { level: 1 }, updatedAt) }"
                                @click="toggleHeading(1)"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5"><path fill="none" d="M0 0H24V24H0z"/><path d="M13 20h-2v-7H4v7H2V4h2v7h7V4h2v16zm8-12v12h-2v-9.796l-2 .536V8.67L19.5 8H21z" fill="currentColor"/></svg>
                            </button>

                            <button
                                type="button"
                                class="leading-0 transition duration-150"
                                :class="{ 'text-blue-9': isActive('heading', { level: 2 }, updatedAt), 'text-gray-9 hover:text-gray-11': !isActive('heading', { level: 2 }, updatedAt) }"
                                @click="toggleHeading(2)"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5"><path fill="none" d="M0 0H24V24H0z"/><path d="M4 4v7h7V4h2v16h-2v-7H4v7H2V4h2zm14.5 4c2.071 0 3.75 1.679 3.75 3.75 0 .857-.288 1.648-.772 2.28l-.148.18L18.034 18H22v2h-7v-1.556l4.82-5.546c.268-.307.43-.709.43-1.148 0-.966-.784-1.75-1.75-1.75-.918 0-1.671.707-1.744 1.606l-.006.144h-2C14.75 9.679 16.429 8 18.5 8z" fill="currentColor"/></svg>
                            </button>

                            <button
                                type="button"
                                class="leading-0 transition duration-150"
                                :class="{ 'text-blue-9': isActive('heading', { level: 3 }, updatedAt), 'text-gray-9 hover:text-gray-11': !isActive('heading', { level: 3 }, updatedAt) }"
                                @click="toggleHeading(3)"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5"><path fill="none" d="M0 0H24V24H0z"/><path d="M22 8l-.002 2-2.505 2.883c1.59.435 2.757 1.89 2.757 3.617 0 2.071-1.679 3.75-3.75 3.75-1.826 0-3.347-1.305-3.682-3.033l1.964-.382c.156.806.866 1.415 1.718 1.415.966 0 1.75-.784 1.75-1.75s-.784-1.75-1.75-1.75c-.286 0-.556.069-.794.19l-1.307-1.547L19.35 10H15V8h7zM4 4v7h7V4h2v16h-2v-7H4v7H2V4h2z" fill="currentColor"/></svg>
                            </button>
                        </div>

                        <div class="space-x-2">
                            <button
                                type="button"
                                class="leading-0 transition duration-150"
                                :class="{ 'text-blue-9': isActive('bulletList', updatedAt), 'text-gray-9 hover:text-gray-11': !isActive('bulletList', updatedAt) }"
                                @click="toggleBulletList()"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5"><path fill="none" d="M0 0h24v24H0z"/><path d="M8 4h13v2H8V4zM4.5 6.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 7a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 6.9a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zM8 11h13v2H8v-2zm0 7h13v2H8v-2z" fill="currentColor"/></svg>
                            </button>

                            <button
                                type="button"
                                class="leading-0 transition duration-150"
                                :class="{ 'text-blue-9': isActive('orderedList', updatedAt), 'text-gray-9 hover:text-gray-11': !isActive('orderedList', updatedAt) }"
                                @click="toggleOrderedList()"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5"><path fill="none" d="M0 0h24v24H0z"/><path d="M8 4h13v2H8V4zM5 3v3h1v1H3V6h1V4H3V3h2zM3 14v-2.5h2V11H3v-1h3v2.5H4v.5h2v1H3zm2 5.5H3v-1h2V18H3v-1h3v4H3v-1h2v-.5zM8 11h13v2H8v-2zm0 7h13v2H8v-2z" fill="currentColor"/></svg>
                            </button>
                        </div>

                        <div class="space-x-2">
                            <button
                                type="button"
                                class="leading-0 transition duration-150"
                                :class="{ 'text-blue-9': isActive('link', updatedAt), 'text-gray-9 hover:text-gray-11': !isActive('link', updatedAt) }"
                                @click="setLink()"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5"><path fill="none" d="M0 0h24v24H0z"/><path d="M18.364 15.536L16.95 14.12l1.414-1.414a5 5 0 1 0-7.071-7.071L9.879 7.05 8.464 5.636 9.88 4.222a7 7 0 0 1 9.9 9.9l-1.415 1.414zm-2.828 2.828l-1.415 1.414a7 7 0 0 1-9.9-9.9l1.415-1.414L7.05 9.88l-1.414 1.414a5 5 0 1 0 7.071 7.071l1.414-1.414 1.415 1.414zm-.708-10.607l1.415 1.415-7.071 7.07-1.415-1.414 7.071-7.07z" fill="currentColor"/></svg>
                            </button>

                            <button
                                type="button"
                                class="leading-0 transition duration-150 text-gray-9 hover:text-gray-11"
                                @click="removeLink()"
                                x-show="isActive('link', updatedAt)"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 17h5v2h-3v3h-2v-5zM7 7H2V5h3V2h2v5zm11.364 8.536L16.95 14.12l1.414-1.414a5 5 0 1 0-7.071-7.071L9.879 7.05 8.464 5.636 9.88 4.222a7 7 0 0 1 9.9 9.9l-1.415 1.414zm-2.828 2.828l-1.415 1.414a7 7 0 0 1-9.9-9.9l1.415-1.414L7.05 9.88l-1.414 1.414a5 5 0 1 0 7.071 7.071l1.414-1.414 1.415 1.414zm-.708-10.607l1.415 1.415-7.071 7.07-1.415-1.414 7.071-7.07z" fill="currentColor"/></svg>
                            </button>
                        </div>

                        <div class="space-x-2">
                            <button
                                type="button"
                                class="leading-0 transition duration-150"
                                :class="{ 'text-blue-9': isActive({ textAlign: 'left' }, updatedAt), 'text-gray-9 hover:text-gray-11': !isActive({ textAlign: 'left' }, updatedAt) }"
                                @click="setTextAlign('left')"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 4h18v2H3V4zm0 15h14v2H3v-2zm0-5h18v2H3v-2zm0-5h14v2H3V9z" fill="currentColor"/></svg>
                            </button>

                            <button
                                type="button"
                                class="leading-0 transition duration-150"
                                :class="{ 'text-blue-9': isActive({ textAlign: 'center' }, updatedAt), 'text-gray-9 hover:text-gray-11': !isActive({ textAlign: 'center' }, updatedAt) }"
                                @click="setTextAlign('center')"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 4h18v2H3V4zm2 15h14v2H5v-2zm-2-5h18v2H3v-2zm2-5h14v2H5V9z" fill="currentColor"/></svg>
                            </button>

                            <button
                                type="button"
                                class="leading-0 transition duration-150"
                                :class="{ 'text-blue-9': isActive({ textAlign: 'right' }, updatedAt), 'text-gray-9 hover:text-gray-11': !isActive({ textAlign: 'right' }, updatedAt) }"
                                @click="setTextAlign('right')"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 4h18v2H3V4zm4 15h14v2H7v-2zm-4-5h18v2H3v-2zm4-5h14v2H7V9z" fill="currentColor"/></svg>
                            </button>
                        </div>

                        <div class="space-x-2">
                            <button
                                type="button"
                                class="leading-0 transition duration-150 text-gray-9 hover:text-gray-11"
                                @click="setHorizontalRule()"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5"><path fill="none" d="M0 0h24v24H0z"/><path d="M2 11h2v2H2v-2zm4 0h12v2H6v-2zm14 0h2v2h-2v-2z" fill="currentColor"/></svg>
                            </button>

                            <button
                                type="button"
                                class="leading-0 transition duration-150"
                                :class="{ 'text-blue-9': isActive('blockquote', updatedAt), 'text-gray-9 hover:text-gray-11': !isActive('blockquote', updatedAt) }"
                                @click="toggleBlockquote()"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5"><path fill="none" d="M0 0h24v24H0z"/><path d="M19.417 6.679C20.447 7.773 21 9 21 10.989c0 3.5-2.457 6.637-6.03 8.188l-.893-1.378c3.335-1.804 3.987-4.145 4.247-5.621-.537.278-1.24.375-1.929.311-1.804-.167-3.226-1.648-3.226-3.489a3.5 3.5 0 0 1 3.5-3.5c1.073 0 2.099.49 2.748 1.179zm-10 0C10.447 7.773 11 9 11 10.989c0 3.5-2.457 6.637-6.03 8.188l-.893-1.378c3.335-1.804 3.987-4.145 4.247-5.621-.537.278-1.24.375-1.929.311C4.591 12.322 3.17 10.841 3.17 9a3.5 3.5 0 0 1 3.5-3.5c1.073 0 2.099.49 2.748 1.179z" fill="currentColor"/></svg>
                            </button>
                        </div>

                        <div class="space-x-2">
                            <button
                                type="button"
                                class="leading-0 transition duration-150 text-gray-9 hover:text-gray-11"
                                @click="$wire.set('codeView', true)"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5"><path fill="none" d="M0 0h24v24H0z"/><path d="M16.95 8.464l1.414-1.414 4.95 4.95-4.95 4.95-1.414-1.414L20.485 12 16.95 8.464zm-9.9 0L3.515 12l3.535 3.536-1.414 1.414L.686 12l4.95-4.95L7.05 8.464z" fill="currentColor"/></svg>
                            </button>
                        </div>
                    </nav>
                </template>

                <div x-ref="editor"></div>
            </div>
        </div>

        @if ($codeView)
            <nav class="menu flex items-center space-x-10 border-b border-gray-6 py-2 px-3 bg-gray-2">
                <button
                    type="button"
                    class="leading-0 transition duration-150 text-gray-9 hover:text-gray-11 text-sm h-5 font-medium"
                    @click="setContent(content);$wire.set('codeView', false);"
                >
                    Back to editor
                </button>
            </nav>
        @endif

        <textarea
            name="editor-content"
            class="appearance-none bg-transparent font-mono w-full border-none py-4 px-3 focus:outline-none focus:ring-0 leading-relaxed {{ $codeView ? '' : 'hidden' }}"
            rows="20"
            wire:model="content"
        ></textarea>
    </div>

    <div class="text-gray-11 text-sm mt-2 ml-1">Word count: {{ $this->wordCount }}</div>
</div>

@push('styles')
    @once
        <link rel="stylesheet" href="{{ asset('dist/css/tiptap.css') }}">
    @endonce
@endpush