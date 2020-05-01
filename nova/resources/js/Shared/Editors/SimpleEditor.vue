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
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="h-4 w-4"
                            fill="currentColor"
                        ><path d="M17.194,10.962A6.271,6.271,0,0,0,12.844.248H4.3a1.25,1.25,0,0,0,0,2.5H5.313a.25.25,0,0,1,.25.25V21a.25.25,0,0,1-.25.25H4.3a1.25,1.25,0,1,0,0,2.5h9.963a6.742,6.742,0,0,0,2.93-12.786Zm-4.35-8.214a3.762,3.762,0,0,1,0,7.523H8.313a.25.25,0,0,1-.25-.25V3a.25.25,0,0,1,.25-.25Zm1.42,18.5H8.313a.25.25,0,0,1-.25-.25V13.021a.25.25,0,0,1,.25-.25h4.531c.017,0,.033,0,.049,0l.013,0h1.358a4.239,4.239,0,0,1,0,8.477Z" /></svg>
                    </button>

                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.italic() }"
                        @click="commands.italic"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="h-4 w-4"
                            fill="currentColor"
                        ><path d="M22.5.248H14.863a1.25,1.25,0,0,0,0,2.5h1.086a.25.25,0,0,1,.211.384L4.78,21.017a.5.5,0,0,1-.422.231H1.5a1.25,1.25,0,0,0,0,2.5H9.137a1.25,1.25,0,0,0,0-2.5H8.051a.25.25,0,0,1-.211-.384L19.22,2.98a.5.5,0,0,1,.422-.232H22.5a1.25,1.25,0,0,0,0-2.5Z" /></svg>
                    </button>

                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.underline() }"
                        @click="commands.underline"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="h-4 w-4"
                            fill="currentColor"
                        ><path d="M22.5,21.248H1.5a1.25,1.25,0,0,0,0,2.5h21a1.25,1.25,0,0,0,0-2.5Z" /><path d="M1.978,2.748H3.341a.25.25,0,0,1,.25.25v8.523a8.409,8.409,0,0,0,16.818,0V3a.25.25,0,0,1,.25-.25h1.363a1.25,1.25,0,0,0,0-2.5H16.3a1.25,1.25,0,0,0,0,2.5h1.363a.25.25,0,0,1,.25.25v8.523a5.909,5.909,0,0,1-11.818,0V3a.25.25,0,0,1,.25-.25H7.7a1.25,1.25,0,1,0,0-2.5H1.978a1.25,1.25,0,0,0,0,2.5Z" /></svg>
                    </button>

                    <div class="w-px bg-gray-300 mx-2">&nbsp;</div>

                    <!-- <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.underline() }"
                        @click="commands.underline"
                    >
                        <icon name="link"></icon>
                    </button> -->

                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.bullet_list() }"
                        @click="commands.bullet_list"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="h-4 w-4"
                            fill="currentColor"
                        ><circle
                            cx="2.5"
                            cy="3.998"
                            r="2.5"
                        /><path d="M8.5,5H23a1,1,0,0,0,0-2H8.5a1,1,0,0,0,0,2Z" /><circle
                            cx="2.5"
                            cy="11.998"
                            r="2.5"
                        /><path d="M23,11H8.5a1,1,0,0,0,0,2H23a1,1,0,0,0,0-2Z" /><circle
                            cx="2.5"
                            cy="19.998"
                            r="2.5"
                        /><path d="M23,19H8.5a1,1,0,0,0,0,2H23a1,1,0,0,0,0-2Z" /></svg>
                    </button>

                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.ordered_list() }"
                        @click="commands.ordered_list"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="h-4 w-4"
                            fill="currentColor"
                        ><path d="M7.75,4.5h15a1,1,0,0,0,0-2h-15a1,1,0,0,0,0,2Z" /><path d="M22.75,11h-15a1,1,0,1,0,0,2h15a1,1,0,0,0,0-2Z" /><path d="M22.75,19.5h-15a1,1,0,0,0,0,2h15a1,1,0,0,0,0-2Z" /><path d="M2.212,17.248A2,2,0,0,0,.279,18.732a.75.75,0,1,0,1.45.386.5.5,0,1,1,.483.63.75.75,0,1,0,0,1.5.5.5,0,1,1-.482.635.75.75,0,1,0-1.445.4,2,2,0,1,0,3.589-1.648.251.251,0,0,1,0-.278,2,2,0,0,0-1.662-3.111Z" /><path d="M4.25,10.748a2,2,0,0,0-4,0,.75.75,0,0,0,1.5,0,.5.5,0,0,1,1,0,1.031,1.031,0,0,1-.227.645L.414,14.029A.75.75,0,0,0,1,15.248H3.5a.75.75,0,0,0,0-1.5H3.081a.249.249,0,0,1-.195-.406L3.7,12.33A2.544,2.544,0,0,0,4.25,10.748Z" /><path d="M4,5.248H3.75A.25.25,0,0,1,3.5,5V1.623A1.377,1.377,0,0,0,2.125.248H1.5a.75.75,0,0,0,0,1.5h.25A.25.25,0,0,1,2,2V5a.25.25,0,0,1-.25.25H1.5a.75.75,0,0,0,0,1.5H4a.75.75,0,0,0,0-1.5Z" /></svg>
                    </button>

                    <div class="w-px bg-gray-300 mx-2">&nbsp;</div>

                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.heading({ level: 1 }) }"
                        @click="commands.heading({ level: 1 })"
                    >
                        H1
                    </button>

                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.heading({ level: 2 }) }"
                        @click="commands.heading({ level: 2 })"
                    >
                        H2
                    </button>

                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        :class="{ 'bg-gray-300': isActive.heading({ level: 3 }) }"
                        @click="commands.heading({ level: 3 })"
                    >
                        H3
                    </button>

                    <div class="w-px bg-gray-300 mx-2">&nbsp;</div>

                    <button
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        @click="commands.createTable({ rowsCount: 3, colsCount: 3, withHeaderRow: false })"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="h-4 w-4"
                            fill="currentColor"
                        ><path fill-rule="evenodd" d="M17,17 L17,22 L19,22 C20.6568542,22 22,20.6568542 22,19 L22,17 L17,17 Z M15,17 L9,17 L9,22 L15,22 L15,17 Z M17,15 L22,15 L22,9 L17,9 L17,15 Z M15,15 L15,9 L9,9 L9,15 L15,15 Z M17,7 L22,7 L22,5 C22,3.34314575 20.6568542,2 19,2 L17,2 L17,7 Z M15,7 L15,2 L9,2 L9,7 L15,7 Z M24,16.1768671 L24,19 C24,21.7614237 21.7614237,24 19,24 L5,24 C2.23857625,24 2.11453371e-15,21.7614237 1.77635684e-15,19 L0,5 C-3.38176876e-16,2.23857625 2.23857625,2.28362215e-15 5,0 L19,0 C21.7614237,-5.07265313e-16 24,2.23857625 24,5 L24,7.82313285 C24.0122947,7.88054124 24.0187107,7.93964623 24.0187107,8 C24.0187107,8.06035377 24.0122947,8.11945876 24,8.17686715 L24,15.8231329 C24.0122947,15.8805412 24.0187107,15.9396462 24.0187107,16 C24.0187107,16.0603538 24.0122947,16.1194588 24,16.1768671 Z M7,2 L5,2 C3.34314575,2 2,3.34314575 2,5 L2,7 L7,7 L7,2 Z M2,9 L2,15 L7,15 L7,9 L2,9 Z M2,17 L2,19 C2,20.6568542 3.34314575,22 5,22 L7,22 L7,17 L2,17 Z" /></svg>
                    </button>

                    <button
                        v-if="isActive.table()"
                        type="button"
                        class="inline-flex bg-transparent border-none text-gray-900 py-1 px-1 mr-1 rounded cursor-pointer hover:bg-gray-200 last:mr-0"
                        @click="commands.deleteTable"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            class="h-4 w-4"
                            fill="currentColor"
                        ><path d="M19,14 C21.7600532,14.0033061 23.9966939,16.2399468 24,19 C24,21.7614237 21.7614237,24 19,24 C16.2385763,24 14,21.7614237 14,19 C14,16.2385763 16.2385763,14 19,14 Z M16.5,19.9375 L21.5,19.9375 C22.017767,19.9375 22.4375,19.517767 22.4375,19 C22.4375,18.482233 22.017767,18.0625 21.5,18.0625 L16.5,18.0625 C15.982233,18.0625 15.5625,18.482233 15.5625,19 C15.5625,19.517767 15.982233,19.9375 16.5,19.9375 Z M12.2898787,17 L9,17 L9,22 L12.6736312,22 C13.0297295,22.7496048 13.515133,23.4258795 14.1010173,24 L5,24 C2.23857625,24 -1.43817996e-15,21.7614237 -1.77635684e-15,19 L-3.55271368e-15,5 C-3.89089055e-15,2.23857625 2.23857625,5.07265313e-16 5,-1.77635684e-15 L19,-1.77635684e-15 C21.7614237,-2.28362215e-15 24,2.23857625 24,5 L24,7.82313285 C24.0122947,7.88054124 24.0187107,7.93964623 24.0187107,8 C24.0187107,8.06035377 24.0122947,8.11945876 24,8.17686715 L24,14.1010173 C23.4258795,13.515133 22.7496048,13.0297295 22,12.6736312 L22,9 L17,9 L17,12.2898787 C16.2775651,12.5048858 15.6040072,12.8333806 15,13.2546893 L15,9 L9,9 L9,15 L13.2546893,15 C12.8333806,15.6040072 12.5048858,16.2775651 12.2898787,17 Z M17,7 L22,7 L22,5 C22,3.34314575 20.6568542,2 19,2 L17,2 L17,7 Z M15,7 L15,2 L9,2 L9,7 L15,7 Z M7,2 L5,2 C3.34314575,2 2,3.34314575 2,5 L2,7 L7,7 L7,2 Z M2,9 L2,15 L7,15 L7,9 L2,9 Z M2,17 L2,19 C2,20.6568542 3.34314575,22 5,22 L7,22 L7,17 L2,17 Z" /></svg>
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
    BulletList,
    Heading,
    ListItem,
    OrderedList,
    Bold,
    Italic,
    Link,
    Table,
    TableHeader,
    TableCell,
    TableRow,
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
                    new BulletList(),
                    new Heading({ levels: [1, 2, 3] }),
                    new ListItem(),
                    new OrderedList(),
                    new Link(),
                    new Bold(),
                    new Italic(),
                    new Underline(),
                    new Placeholder({
                        emptyEditorClass: `is-editor-empty`,
                        emptyNodeClass: 'is-empty',
                        emptyNodeText: 'Write something...',
                        showOnlyWhenEditable: true,
                        showOnlyCurrent: true
                    }),
                    new Table({
                        resizable: true
                    }),
                    new TableHeader(),
                    new TableCell(),
                    new TableRow()
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
