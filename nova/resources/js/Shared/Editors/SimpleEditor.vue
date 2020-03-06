<template>
    <div class="editor block relative w-full rounded-md overflow-hidden bg-gray-50 border border-gray-200 shadow-sm focus-within:bg-white">
        <editor-menu-bar v-slot="{ commands, isActive }" :editor="editor">
            <div class="flex items-center justify-between relative py-2 px-3 bg-gray-100 border-b border-gray-200">
                <div class="flex items-center flex-1">
                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.bold() }"
                        @click="commands.bold"
                    >
                        <icon name="bold"></icon>
                    </button>

                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.italic() }"
                        @click="commands.italic"
                    >
                        <icon name="italic"></icon>
                    </button>

                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.underline() }"
                        @click="commands.underline"
                    >
                        <icon name="underline"></icon>
                    </button>

                    <div class="w-px bg-gray-300 mx-2">&nbsp;</div>

                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.underline() }"
                        @click="commands.underline"
                    >
                        <icon name="link"></icon>
                    </button>

                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.bullet_list() }"
                        @click="commands.bullet_list"
                    >
                        <icon name="list"></icon>
                    </button>

                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.ordered_list() }"
                        @click="commands.ordered_list"
                    >
                        <icon name="list"></icon>
                    </button>

                    <div class="w-px bg-gray-300 mx-2">&nbsp;</div>

                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.underline() }"
                        @click="commands.underline"
                    >
                        <svg
                            version="1.1"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            class="h-4 w-4"
                        ><g fill="currentColor"><path d="M22.5 23.271h-21 -5.46392e-08c-.690356-3.01764e-08-1.25-.559644-1.25-1.25 3.01764e-08-.690356.559644-1.25 1.25-1.25h21 -5.46392e-08c.690356-3.01764e-08 1.25.559644 1.25 1.25 3.01764e-08.690356-.559644 1.25-1.25 1.25Z" /><path d="M19.637 3.225h-18.137l-5.46392e-08-1.33227e-15c-.690356-3.01764e-08-1.25-.559644-1.25-1.25 3.01764e-08-.690356.559644-1.25 1.25-1.25h18.137l-5.46392e-08 1.33227e-15c.690356-3.01764e-08 1.25.559644 1.25 1.25 3.01764e-08.690356-.559644 1.25-1.25 1.25Z" /><path d="M15.818 9.907h-14.318l-5.46392e-08-1.77636e-15c-.690356-3.01764e-08-1.25-.559644-1.25-1.25 3.01764e-08-.690356.559644-1.25 1.25-1.25h14.318l-5.46392e-08 1.77636e-15c.690356-3.01764e-08 1.25.559644 1.25 1.25 3.01764e-08.690356-.559644 1.25-1.25 1.25Z" /><path d="M18.682 16.589h-17.182 -5.46392e-08c-.690356-3.01764e-08-1.25-.559644-1.25-1.25 3.01764e-08-.690356.559644-1.25 1.25-1.25h17.182l4.66887e-08 1.77636e-15c.690356 5.21204e-08 1.25.559644 1.25 1.25 -5.21204e-08.690356-.559644 1.25-1.25 1.25Z" /></g></svg>
                    </button>

                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.underline() }"
                        @click="commands.underline"
                    >
                        <svg
                            version="1.1"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            class="h-4 w-4"
                        ><g fill="currentColor"><path d="M22 23.748h-20 -5.46392e-08c-.690356-3.01764e-08-1.25-.559644-1.25-1.25 3.01764e-08-.690356.559644-1.25 1.25-1.25h20 -5.46392e-08c.690356-3.01764e-08 1.25.559644 1.25 1.25 3.01764e-08.690356-.559644 1.25-1.25 1.25Z" /><path d="M22 2.748h-20l-5.46392e-08-1.33227e-15c-.690356-3.01764e-08-1.25-.559644-1.25-1.25 3.01764e-08-.690356.559644-1.25 1.25-1.25h20l-5.46392e-08 1.33227e-15c.690356-3.01764e-08 1.25.559644 1.25 1.25 3.01764e-08.690356-.559644 1.25-1.25 1.25Z" /><path d="M20 9.748h-16l-5.46392e-08-1.77636e-15c-.690356-3.01764e-08-1.25-.559644-1.25-1.25 3.01764e-08-.690356.559644-1.25 1.25-1.25h16l-5.46392e-08 1.77636e-15c.690356-3.01764e-08 1.25.559644 1.25 1.25 3.01764e-08.690356-.559644 1.25-1.25 1.25Z" /><path d="M17.5 16.748h-11 -5.46392e-08c-.690356-3.01764e-08-1.25-.559644-1.25-1.25 3.01764e-08-.690356.559644-1.25 1.25-1.25h11l4.66887e-08 1.77636e-15c.690356 5.21204e-08 1.25.559644 1.25 1.25 -5.21204e-08.690356-.559644 1.25-1.25 1.25Z" /></g></svg>
                    </button>

                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.underline() }"
                        @click="commands.underline"
                    >
                        <svg
                            version="1.1"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            class="h-4 w-4"
                        ><g fill="currentColor"><path d="M22.476 23.248h-20.952 -5.46392e-08c-.690356-3.01764e-08-1.25-.559644-1.25-1.25 3.01764e-08-.690356.559644-1.25 1.25-1.25h20.952 -5.46392e-08c.690356-3.01764e-08 1.25.559644 1.25 1.25 3.01764e-08.690356-.559644 1.25-1.25 1.25Z" /><path d="M22.476 3.248h-18.096l-5.46392e-08-1.33227e-15c-.690356-3.01764e-08-1.25-.559644-1.25-1.25 3.01764e-08-.690356.559644-1.25 1.25-1.25h18.1l-5.46392e-08 1.33227e-15c.690356-3.01764e-08 1.25.559644 1.25 1.25 3.01764e-08.690356-.559644 1.25-1.25 1.25Z" /><path d="M22.476 9.915h-14.286l-5.46392e-08-1.77636e-15c-.690356-3.01764e-08-1.25-.559644-1.25-1.25 3.01764e-08-.690356.559644-1.25 1.25-1.25h14.286l-5.46392e-08 1.77636e-15c.690356-3.01764e-08 1.25.559644 1.25 1.25 3.01764e-08.690356-.559644 1.25-1.25 1.25Z" /><path d="M22.476 16.581h-17.143 -5.46392e-08c-.690356-3.01764e-08-1.25-.559644-1.25-1.25 3.01764e-08-.690356.559644-1.25 1.25-1.25h17.143l-5.46392e-08 1.77636e-15c.690356-3.01764e-08 1.25.559644 1.25 1.25 3.01764e-08.690356-.559644 1.25-1.25 1.25Z" /></g></svg>
                    </button>

                    <div class="w-px bg-gray-300 mx-2">&nbsp;</div>

                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.underline() }"
                        @click="commands.underline"
                    >
                        <svg
                            version="1.1"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            class="h-4 w-4"
                        ><path d="M24 2v0c0-1.10457-.895431-2-2-2h-20l-8.74228e-08 3.55271e-15c-1.10457 4.82823e-08-2 .895431-2 2 0 0 0 0 0 0v20l2.13163e-14-3.01992e-07c-1.66785e-07 1.10457.89543 2 2 2h20l-8.74228e-08-7.10543e-15c1.10457 4.82823e-08 2-.89543 2-2Zm-2.5 9h-8 -2.18557e-08c-.276142-1.20706e-08-.5-.223858-.5-.5 0 0 0-1.77636e-15 0-1.77636e-15v-8l5.32907e-15 7.54979e-08c-4.16963e-08-.276142.223858-.5.5-.5h8l-2.18557e-08 3.55271e-15c.276142-1.20706e-08.5.223858.5.5v8l7.10543e-15 4.37114e-08c0 .276142-.223858.5-.5.5Zm-10.5-8.5v8 0c0 .276142-.223858.5-.5.5h-8 -2.18557e-08c-.276142-1.20706e-08-.5-.223858-.5-.5 0 0 0-1.77636e-15 0-1.77636e-15v-8l7.10543e-15-5.36422e-08c4.16963e-08-.276142.223858-.5.5-.5h8 -1.58933e-08c.276142 2.08482e-08.5.223858.5.5Zm-8.5 10.5h8 -2.18557e-08c.276142-1.20706e-08.5.223858.5.5v8 0c0 .276142-.223858.5-.5.5h-8 -2.18557e-08c-.276142-1.20706e-08-.5-.223858-.5-.5 0 0 0 0 0 0v-8l3.55271e-15-3.17865e-08c4.16963e-08-.276142.223858-.5.5-.5Zm10.5 8.5v-8l5.32907e-15 7.54979e-08c-4.16963e-08-.276142.223858-.5.5-.5h8 -2.18557e-08c.276142-1.20706e-08.5.223858.5.5v8 0c0 .276142-.223858.5-.5.5h-8 -5.96244e-09c-.276142-4.49893e-08-.5-.223858-.5-.5Z" fill="currentColor" /></svg>
                    </button>
                </div>

                <div class="flex-shrink text-sm">
                    Code view
                </div>
            </div>
        </editor-menu-bar>

        <editor-content class="editor-content break-words p-4" :editor="editor"></editor-content>
    </div>
</template>

<script>
import { Editor, EditorContent, EditorMenuBar } from 'tiptap';
import {
    Blockquote,
    BulletList,
    CodeBlock,
    Heading,
    ListItem,
    OrderedList,
    Bold,
    Code,
    Italic,
    Link,
    Underline,
    Placeholder
} from 'tiptap-extensions';

export default {
    name: 'SimpleEditor',

    components: { EditorContent, EditorMenuBar },

    props: {
        height: {
            type: String,
            default: null
        },
        value: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            editor: new Editor({
                extensions: [
                    new Blockquote(),
                    new BulletList(),
                    new CodeBlock(),
                    new Heading({ levels: [1, 2, 3] }),
                    new ListItem(),
                    new OrderedList(),
                    new Link(),
                    new Bold(),
                    new Code(),
                    new Italic(),
                    new Underline(),
                    new Placeholder({
                        emptyEditorClass: `is-editor-empty`,
                        emptyNodeClass: 'is-empty',
                        emptyNodeText: 'Write something...',
                        showOnlyWhenEditable: true,
                        showOnlyCurrent: true
                    })
                ],
                content: this.value.content,
                onInit: ({ view }) => {
                    if (this.height != null) {
                        view.dom.classList.add(this.height);
                    }
                },
                onUpdate: ({ getJSON, getHTML }) => {
                    this.content = getHTML();
                    this.source = getJSON();
                }
            }),
            content: this.value.content,
            source: this.value.source
        };
    },

    watch: {
        content () {
            this.broadcastUpdate();
        },

        source () {
            this.broadcastUpdate();
        }
    },

    beforeDestroy () {
        this.editor.destroy();
    },

    methods: {
        broadcastUpdate () {
            this.$emit('input', {
                content: this.content,
                source: this.source
            });
        }
    }
};
</script>
