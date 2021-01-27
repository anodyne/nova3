import { Editor } from '@tiptap/core';
import { defaultExtensions } from '@tiptap/starter-kit';

window.tiptap = new Editor({
    element: document.querySelector('.tiptap-editor'),
    extensions: defaultExtensions(),
    content: '<p>Your content.</p>'
});

window.tiptap.on('update', () => {
    console.log(this);

    const html = this.getHTML();

    this.element.dispatchEvent(new CustomEvent(
        'tiptap-updated',
        { detail: html }
    ));
});
