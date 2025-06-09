import * as FilePond from 'filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import {
    openEditor,
    processImage,
    createDefaultImageReader,
    createDefaultImageWriter,
    getEditorDefaults,
} from '@pqina/pintura';
import FilePondPluginImageEditor from '@pqina/filepond-plugin-image-editor';
import FilePondPluginFilePoster from 'filepond-plugin-file-poster';
import merge from 'lodash/merge';

export default function registerFilepond() {
    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        // FilePondPluginImageEditor,
        FilePondPluginFilePoster,
    );

    FilePond.setOptions({
        onwarning: (code, message, file) => {
            console.warn('[FilePond warning]', code, message, file);
        },
        onaddfile: (err, file) => {
            console.log('[FilePond addfile]', file);
        },
    });

    window.Alpine.data('filepond', (existingFile = null, customOptions = {}) => ({
        pond: null,

        async init() {
            console.log('[Filepond] init');

            const element = this.$refs.input;
            if (!element) console.error('[Filepond] No element found');

            const component = element.closest('[wire\\:id]');
            const wire = window.Livewire.find(component?.getAttribute('wire:id'));

            const defaultOptions = {
                allowFilePoster: true,
                // allowImageEditor: true,
                allowImagePreview: true,
                allowPaste: false,
                allowReorder: false,
                credits: false,
                // filePosterMaxHeight: 256,
                // imageEditorAllowEdit: true,
                // styleImageEditorButtonEditItemPosition: 'bottom center',
                stylePanelLayout: 'compact',

                server: {
                    load: async (source, load) => {
                        console.log('[Filepond] server.load');

                        const response = await fetch(source, {
                            cache: 'no-store',
                        });
                        const blob = await response.blob();

                        load(blob);
                    },
                    process: (fieldName, file, metadata, load, error, progress) => {
                        console.log('[Filepond] server.process');

                        wire.upload('image', file, load, error, progress);
                    },
                    revert: async (filename, load) => {
                        console.log('[Filepond] server.revert');

                        wire.set('image', null);
                        wire.removeUpload('image', filename, load);
                    },
                },

                // imageEditor: {
                //     createEditor: openEditor,
                //     imageReader: [createDefaultImageReader],
                //     imageWriter: [createDefaultImageWriter],
                //     imageProcessor: processImage,
                //     editorOptions: {
                //         ...getEditorDefaults(),
                //         utils: [
                //             'crop',
                //             'filter',
                //             'finetune',
                //             'resize',
                //         ],
                //         cropSelectPresetOptions: [
                //             [undefined, 'Custom'],
                //             [1, 'Square'],
                //             [4 / 3, 'Landscape (4:3)'],
                //             [3 / 2, 'Landscape (3:2)'],
                //             [16 / 9, 'Landscape (16:9)'],
                //             [3 / 4, 'Portrait (3:4)'],
                //             [2 / 3, 'Portrait (2:3)'],
                //             [9 / 16, 'Portrait (9:16)'],
                //         ],
                //     },
                //     // willClose: () => {
                //     //     console.log('[Pintura] Editor closing');

                //     //     // Force FilePond to refresh its preview after a short delay
                //     //     setTimeout(() => {
                //     //         if (this.pond) {
                //     //         // Force a re-render of the file item
                //     //             const files = this.pond.getFiles();
                //     //             if (files.length > 0) {
                //     //                 const file = files[0];
                //     //                 // Trigger a refresh by briefly removing and re-adding the file
                //     //                 this.pond.removeFile(file.id, { revert: false });
                //     //                 setTimeout(() => {
                //     //                     if (file.source) {
                //     //                         this.pond.addFile(file.source, { type: 'local' });
                //     //                     }
                //     //                 }, 50);
                //     //             }
                //     //         }
                //     //     }, 100);
                //     // },
                // },
            };

            if (existingFile?.url) {
                defaultOptions.files = [
                    {
                        source: existingFile.url,
                        options: {
                            type: 'local',
                        },
                    },
                ];
            }

            const options = merge({}, defaultOptions, customOptions);

            this.pond = FilePond.create(element, options);

            // this.$wire.on('mediaUploaded', (event) => {
            //     console.log('[Filepond] Image updated event received');
            //     console.log(event);

            //     this.pond.removeFiles({ revert: false });
            //     this.pond.addFile(event.path, {
            //         type: 'local',
            //     });
            // });
        },
    }));
}
