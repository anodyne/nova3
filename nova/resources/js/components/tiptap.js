import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import TextAlign from '@tiptap/extension-text-align';
import Link from '@tiptap/extension-link';
import pretty from 'pretty';

export default (content) => ({
    content,
    updatedAt: Date.now(), // force Alpine to re-render on selection change

    init(element) {
        window.editor = new Editor({
            element,
            extensions: [
                StarterKit,
                Underline,
                TextAlign.configure({
                    alignments: ['left', 'center', 'right'],
                    types: ['heading', 'paragraph'],
                }),
                Link.configure({
                    openOnClick: false,
                }),
            ],
            content: this.content,
            inFocus: false,
            editorProps: {
                attributes: {
                    class: 'prose dark:prose-invert max-w-none py-4 px-3 max-h-[35rem] overflow-y-scroll focus:outline-none',
                },
            },
            onFocus: () => {
                this.inFocus = true;
                this.updatedAt = Date.now();
            },
            onSelectionUpdate: () => {
                this.updatedAt = Date.now();
            },
            onUpdate: ({ editor }) => {
                this.updatedAt = Date.now();
                this.content = pretty(editor.getHTML(), { ocd: true });
            },
            onCreate: ({ editor }) => {
                this.updatedAt = Date.now();
                this.content = pretty(editor.getHTML(), { ocd: true });
            },
        });
    },

    isActive(type, opts = {}, updatedAt) {
        return window.editor.isActive(type, opts);
    },

    removeLink() {
        return window.editor.chain().unsetLink().focus().run();
    },

    setContent(newContent) {
        return window.editor.commands.setContent(newContent);
    },

    setHorizontalRule() {
        return window.editor.chain().setHorizontalRule().focus().run();
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

    setParagraph() {
        return window.editor.commands.setParagraph();
    },

    setTextAlign(direction) {
        return window.editor.chain().setTextAlign(direction).focus().run();
    },

    toggleBlockquote() {
        return window.editor.chain().toggleBlockquote().focus().run();
    },

    toggleBold() {
        return window.editor.chain().toggleBold().focus().run();
    },

    toggleBulletList() {
        return window.editor.chain().toggleBulletList().focus().run();
    },

    toggleHeading(level) {
        return window.editor.chain().toggleHeading({ level }).focus().run();
    },

    toggleItalic() {
        return window.editor.chain().toggleItalic().focus().run();
    },

    toggleOrderedList() {
        return window.editor.chain().toggleOrderedList().focus().run();
    },

    toggleUnderline() {
        return window.editor.chain().toggleUnderline().focus().run();
    },
});
