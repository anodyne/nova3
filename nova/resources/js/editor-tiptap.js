import { Editor as TipTap } from '@tiptap/core';
import { defaultExtensions } from '@tiptap/starter-kit';

window.setupEditor = (content) => ({
    content,
    inFocus: false,
    // updatedAt is to force Alpine to
    // rerender on selection change
    updatedAt: Date.now(),
    editor: null,

    init(el) {
        const editor = new TipTap({
            element: el,
            extensions: defaultExtensions(),
            content: this.content,
            editorProps: {
                attributes: {
                    class: 'prose py-4 focus:outline-none',
                },
            },
        });

        editor.on('update', () => {
            this.content = this.editor.getHTML();
        });

        editor.on('focus', () => {
            this.inFocus = true;
        });

        editor.on('selection', () => {
            this.updatedAt = Date.now();
        });

        this.editor = editor;
    },
});
