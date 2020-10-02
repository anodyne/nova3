<template>
    <div class="editor group flex flex-col items-start relative w-full rounded-md py-2 px-3 border border-gray-200 shadow-sm bg-white transition ease-in-out duration-200 focus-within:border-blue-300 focus-within:shadow-outline-blue space-y-6">
        <editor-menu-bar v-slot="{ commands, isActive }" v-bind:editor="editor">
            <div class="menubar">
                <button
                    class="menubar__button"
                    v-bind:class="{ 'is-active': isActive.bold() }"
                    v-on:click="commands.bold"
                >
                    BOLD
                </button>
            </div>
        </editor-menu-bar>

        <!-- <editor-menu-bubble
            v-slot="{ commands, isActive, menu }"
            v-bind:editor="editor"
            v-bind:keep-in-bounds="true"
            v-on:hide="hideLinkEditor"
        >
            <div
                class="bubble-menu"
                v-bind:class="{ 'is-active': menu.isActive }"
                v-bind:style="{ left: `${menu.left}px`, bottom: `${menu.bottom}px` }"
            >
                <div v-if="showLinkInput" class="flex items-center">
                    <input
                        ref="linkInput"
                        v-model="currentUrl"
                        class="w-48 bg-transparent text-white focus:outline-none"
                        placeholder="https://"
                        v-on:keyup.enter="saveLink"
                        v-on:keyup.esc="hideLinkEditor"
                    >
                    <button
                        class="flex items-center ml-2 text-white"
                        v-on:click="hideLinkEditor"
                    >
                        Close
                    </button>
                </div>
                <template v-else>
                    <button
                        class="menu-button"
                        v-bind:class="{ 'is-active': isActive.bold() }"
                        v-on:click="commands.bold"
                    >
                        Bold
                    </button>

                    <button
                        class="menu-button"
                        v-bind:class="{ 'is-active': isActive.italic() }"
                        v-on:click="commands.italic"
                    >
                        Italic
                    </button>

                    <button
                        class="menu-button"
                        v-bind:class="{ 'is-active': isActive.underline() }"
                        v-on:click="commands.underline"
                    >
                        Underline
                    </button>

                    <button
                        class="menu-button"
                        v-bind:class="{ 'is-active': isActive.alignment({ align: 'left' }) }"
                        v-on:click="commands.alignment({ align: 'left' })"
                    >
                        Align Left
                    </button>

                    <button
                        class="menu-button"
                        v-bind:class="{ 'is-active': isActive.alignment({ align: 'center' }) }"
                        v-on:click="commands.alignment({ align: 'center' })"
                    >
                        Align Center
                    </button>

                    <button
                        class="menu-button"
                        v-bind:class="{ 'is-active': isActive.alignment({ align: 'right' }) }"
                        v-on:click="commands.alignment({ align: 'right' })"
                    >
                        Align Right
                    </button>

                    <button
                        class="menu-button"
                        v-bind:class="{ 'is-active': isActive.code() }"
                        v-on:click="commands.code"
                    >
                        Code
                    </button>

                    <button
                        class="menu-button ml-2"
                        v-bind:class="{ 'is-active': editor.isActive.link() }"
                        v-on:click="showLinkEditor"
                    >
                        Link
                    </button>
                </template>
            </div>
        </editor-menu-bubble>

        <editor-floating-menu v-slot="{ commands, isActive, menu }" v-bind:editor="editor">
            <div
                class="floating-menu"
                v-bind:class="{ 'is-active': menu.isActive }"
                v-bind:style="{ top: `${menu.top}px` }"
            >
                <button
                    class="menu-button"
                    v-bind:class="{ 'is-active': isActive.bullet_list() }"
                    v-on:click="commands.bullet_list"
                >
                    Bulleted List
                </button>

                <button
                    class="menu-button"
                    v-bind:class="{ 'is-active': isActive.ordered_list() }"
                    v-on:click="commands.ordered_list"
                >
                    Ordered List
                </button>
            </div>
        </editor-floating-menu> -->

        <editor-content v-bind:editor="editor" class="editor__content"></editor-content>
    </div>
</template>

<script>
import {
    Editor,
    EditorContent,
    EditorMenuBar,
    EditorMenuBubble,
    EditorFloatingMenu
} from 'tiptap';

import {
    Alignment,
    Bold,
    Italic,
    Underline,
    Code,
    Link,
    Heading,
    ListItem,
    BulletList,
    OrderedList,
    History,
    Placeholder
} from 'tiptap-extensions';

export default {
    name: 'SimpleEditor',

    components: {
        EditorContent,
        EditorMenuBar,
        EditorMenuBubble,
        EditorFloatingMenu
    },

    props: {
        value: {
            type: String,
            default: ''
        }
    },

    data () {
        return {
            editor: new Editor({
                extensions: [
                    new Alignment(),
                    new Bold(),
                    new Italic(),
                    new Underline(),
                    new Code(),
                    new Link(),
                    new Heading({ levels: [1, 2, 3] }),
                    new ListItem(),
                    new BulletList(),
                    new OrderedList(),
                    new History(),
                    new Placeholder({
                        emptyEditorClass: 'is-editor-empty',
                        emptyNodeClass: 'is-empty',
                        emptyNodeText: 'Starting writing...',
                        showOnlyWhenEditable: true,
                        showOnlyCurrent: true
                    })
                ],
                content: this.value,
                onUpdate: ({ getHTML }) => {
                    this.$emit('input', getHTML());
                }
            }),
            showLinkInput: false,
            currentUrl: ''
        };
    },

    beforeDestroy () {
        this.editor.destroy();
    },

    created () {
        console.log('created simple editor');
        console.log(this.editor);
    },

    methods: {
        showLinkEditor () {
            this.currentUrl = this.editor.getMarkAttrs('link').href;
            this.showLinkInput = true;

            this.$nextTick(() => {
                this.$refs.linkInput.focus();
            });
        },

        hideLinkEditor () {
            this.showLinkInput = false;
        },

        saveLink () {
            this.editor.commands.link({ href: this.currentUrl });
            this.hideLinkEditor();
        }
    }
};
</script>
