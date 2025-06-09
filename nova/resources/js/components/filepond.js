import * as FilePond from 'filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginFilePoster from 'filepond-plugin-file-poster';
import merge from 'lodash/merge';

export default function registerFilepond() {
    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginFilePoster,
    );

    window.Alpine.data('filepond', (existingFile = null, customOptions = {}) => ({
        pond: null,

        async init() {
            const element = this.$refs.input;
            if (!element) console.error('[Filepond] No element found');

            const component = element.closest('[wire\\:id]');
            const wire = window.Livewire.find(component?.getAttribute('wire:id'));

            const defaultOptions = {
                allowFilePoster: true,
                allowImagePreview: true,
                allowPaste: false,
                allowReorder: false,
                stylePanelLayout: 'compact',
                credits: false,

                server: {
                    load: async (source, load) => {
                        const response = await fetch(source, {
                            cache: 'no-store',
                        });
                        const blob = await response.blob();

                        load(blob);
                    },
                    process: (fieldName, file, metadata, load, error, progress) => {
                        wire.upload('image', file, load, error, progress);
                    },
                    revert: async (filename, load) => {
                        wire.set('image', null);
                        wire.removeUpload('image', filename, load);
                    },
                },
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
        },
    }));
}
