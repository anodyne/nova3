<template>
    <div class="editor group flex flex-col items-start relative w-full space-y-6">
        <editor-menu-bar v-slot="{ commands, isActive }" v-bind:editor="editor">
            <div class="menubar">
                <button
                    class="menubar__button"
                    type="button"
                    v-bind:class="{ 'is-active': isActive.bold() }"
                    v-on:click="commands.bold"
                >
                    <svg
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-gray-500"
                    ><path
                        d="M5.5 4.25C5.5 3.56 6.06 3 6.75 3h3.501c2.403 0 3.999 1.988 3.999 4 0 .872-.3 1.738-.834 2.44.904.703 1.581 1.802 1.581 3.31 0 2.863-2.437 4.245-4.244 4.245H6.75c-.69 0-1.25-.56-1.25-1.25V4.25zM8 11v3.495h2.753c.811 0 1.744-.618 1.744-1.745 0-1.129-.937-1.75-1.744-1.75H8zm0-2.5h2.248A1.5 1.5 0 0011.75 7c0-.78-.62-1.5-1.499-1.5H8v3z"
                        fill="currentColor"
                        fill-rule="nonzero"
                    /></svg>
                </button>

                <button
                    class="menubar__button"
                    type="button"
                    v-bind:class="{ 'is-active': isActive.italic() }"
                    v-on:click="commands.italic"
                >
                    <svg
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-gray-500"
                    ><path
                        d="M16 3a.5.5 0 010 1h-3.157L8.227 16H11.5a.5.5 0 010 1H4a.5.5 0 010-1h3.156l4.615-12H8.5a.5.5 0 010-1H16z"
                        fill="currentColor"
                        fill-rule="nonzero"
                    /></svg>
                </button>
            </div>
        </editor-menu-bar>

        <editor-content v-bind:editor="editor" class="editor__content"></editor-content>
    </div>
</template>

<script>
import {
    Editor,
    EditorContent,
    EditorMenuBar
} from 'tiptap';

import {
    Bold,
    Italic,
    Placeholder
} from 'tiptap-extensions';

export default {
    name: 'PostsEditor',

    components: {
        EditorContent,
        EditorMenuBar
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
                    new Bold(),
                    new Italic(),
                    new Placeholder({
                        emptyEditorClass: 'is-editor-empty',
                        emptyNodeClass: 'is-empty',
                        emptyNodeText: 'Write something...',
                        showOnlyWhenEditable: true,
                        showOnlyCurrent: true
                    })
                ],
                content: `
          <h2>
            Hi there,
          </h2>
          <p>
            this is a very <em>basic</em> example of tiptap.
          </p>
          <pre><code>body { display: none; }</code></pre>
          <ul>
            <li>
              A regular list
            </li>
            <li>
              With regular items
            </li>
          </ul>
          <blockquote>
            It's amazing 👏
            <br />
            – mom
          </blockquote>
        `,
                onUpdate: ({ getHTML }) => {
                    this.$emit('input', getHTML());
                }
            })
        };
    },

    beforeDestroy () {
        console.log('before destroying editor');
        this.editor.destroy();
    }
};
</script>
