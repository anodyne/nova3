import { Editor as TipTap } from '@tiptap/core';
import { defaultExtensions } from '@tiptap/starter-kit';

export default (content, element) => ({
    content,
    element,
    inFocus: false,
    updatedAt: Date.now(), // updatedAt is to force Alpine to re-render on selection change
    editor: null,

    init() {
        const editor = new TipTap({
            element: this.element,
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
