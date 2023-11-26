import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import Link from '@tiptap/extension-link';
import TextAlign from '@tiptap/extension-text-align';
import CharacterCount from '@tiptap/extension-character-count';
import debounce from 'lodash/debounce';
import pluralize from 'pluralize';
import pretty from 'pretty';
import numeral from 'numeral';

export default (content) => ({
    editor: null,
    content,
    codeView: false,
    updatedAt: Date.now(), // force Alpine to re-render on selection change

    init(element) {
        window.editor = new Editor({
            element,
            extensions: [
                StarterKit,
                Underline,
                Link.configure({
                    openOnClick: false,
                }),
                TextAlign.configure({
                    alignments: ['left', 'center', 'right'],
                    types: ['heading', 'paragraph'],
                }),
                CharacterCount,
            ],
            content: this.content,
            editorProps: {
                attributes: {
                    class: 'prose dark:prose-invert max-w-none py-4 px-4 max-h-[35rem] overflow-y-scroll focus:outline-none',
                },
            },
            onFocus: () => {
                this.updatedAt = Date.now();
            },
            onSelectionUpdate: () => {
                this.updatedAt = Date.now();
            },
            onUpdate: debounce(({ editor }) => {
                this.updatedAt = Date.now();
                this.content = pretty(editor.getHTML(), { ocd: true });
            }, 500),
            onCreate: ({ editor }) => {
                this.updatedAt = Date.now();
                this.content = pretty(editor.getHTML(), { ocd: true });
            },
        });

        this.$watch('content', (content) => {
            // If the new content matches TipTap's then we just skip.
            if (content === window.editor.getHTML()) return;

            /*
            Otherwise, it means that a force external to TipTap
            is modifying the data on this Alpine component,
            which could be Livewire itself.
            In this case, we just need to update TipTap's
            content and we're good to do.
            For more information on the `setContent()` method, see:
            https://www.tiptap.dev/api/commands/set-content
            */
            window.editor.commands.setContent(content, false);
        });
    },

    setLink() {
        const previousUrl = window.editor.getAttributes('link').href;
        const url = window.prompt('URL', previousUrl);

        // Cancelled
        if (url === null) {
            return;
        }

        // Empty
        if (url === '') {
            window.editor.chain().extendMarkRange('link').unsetLink().focus()
                .run();

            return;
        }

        // Update link
        window.editor.chain().extendMarkRange('link').setLink({ href: url }).focus()
            .run();
    },

    wordCount() {
        const count = numeral(window.editor.storage.characterCount.words()).format('0,0');

        return `${count} ${pluralize('word', count)}`;
    },
});
