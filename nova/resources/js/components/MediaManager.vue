<template>
    <div class="form-group">
        <div v-show="!uploadedFile">
            <div v-if="allowMultiple || (!allowMultiple && files.length == 0)">
                <label
                    for="file-upload"
                    class="btn btn-secondary"
                    v-html="showIcon('add')"
                />
                <input
                    id="file-upload"
                    type="file"
                    name="file"
                    class="hidden"
                    @change="processFile"
                >
            </div>

            <div
                id="sortable"
                class="row mt-3"
            >
                <div
                    v-for="file in files"
                    :key="file.id"
                    :data-id="file.id"
                    class="col-sm-6 col-lg-3 draggable-item"
                >
                    <div class="card">
                        <img
                            :src="getFile(file)"
                            class="card-img-top"
                        >
                        <div class="card-footer d-flex justify-content-between">
                            <div>
                                <span v-if="allowMultiple">
                                    <a
                                        v-if="!isPrimary(file)"
                                        href="#"
                                        class="card-link mr-2"
                                        @click.prevent="makePrimary(file.id)"
                                        v-html="showIcon('star')"
                                    />
                                    <span
                                        v-if="isPrimary(file)"
                                        class="card-link text-warning mr-2"
                                        v-html="showIcon('star')"
                                    />
                                </span>
                                <a
                                    href="#"
                                    class="card-link text-danger"
                                    @click.prevent="deleteFile(file.id)"
                                    v-html="showIcon('delete')"
                                />
                            </div>
                            <div v-if="allowMultiple">
                                <div
                                    class="card-link text-subtle sortable-handle"
                                    v-html="showIcon('bars')"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-show="uploadedFile">
            <div id="crop"/>

            <div class="d-flex justify-content-around">
                <span>
                    <button
                        class="btn btn-success"
                        @click.prevent="saveFile"
                        v-html="showIcon('upload')"
                    />
                    <button
                        class="btn btn-secondary ml-2"
                        @click.prevent="reset"
                        v-html="showIcon('close')"
                    />
                </span>
            </div>
        </div>
    </div>
</template>

<script>
import _ from 'lodash';
import Croppie from 'croppie';
import pluralize from 'pluralize';
import Sortable from 'sortablejs';

export default {
    props: {
        allowMultiple: { type: Boolean, default: true },
        item: { type: Object, required: true },
        type: { type: String, required: true }
    },

    data () {
        return {
            crop: {},
            files: this.item.media,
            uploadedFile: ''
        };
    },

    mounted () {
        this.createCropper();

        if (this.allowMultiple) {
            Sortable.create(document.getElementById('sortable'), {
                draggable: '.draggable-item',
                handle: '.sortable-handle',
                onEnd (event) {
                    const order = [];

                    $(event.from).children().each(() => {
                        const id = $(this).data('id');

                        if (id) {
                            order.push(id);
                        }
                    });

                    Nova.request().patch(route('media.reorder'), {
                        media: order
                    });
                }
            });
        }
    },

    methods: {
        createCropper () {
            this.crop = new Croppie(document.getElementById('crop'), {
                boundary: {
                    width: Math.min(500, window.innerWidth - 10),
                    height: Math.min(500, window.innerHeight - 10)
                },
                customClass: 'crop-container',
                viewport: {
                    width: Math.min(500, window.innerWidth - 10),
                    height: Math.min(500, window.innerHeight - 10)
                }
            });
        },

        createFile (file) {
            const reader = new FileReader();
            const self = this;

            reader.onload = (event) => {
                self.uploadedFile = event.target.result;

                self.crop.bind({
                    url: self.uploadedFile
                });
            };

            reader.readAsDataURL(file);
        },

        deleteFile (id) {
            const self = this;

            $.confirm({
                title: self.lang('media-confirm-delete-title'),
                content: self.lang('media-confirm-delete-message'),
                columnClass: 'medium',
                theme: 'dark',
                buttons: {
                    confirm: {
                        text: self.lang('delete'),
                        btnClass: 'btn-danger',
                        action () {
                            Nova.request().delete(route('media.destroy', { media: id }))
                                .then(() => {
                                    const index = _.findIndex(self.files, (file) => {
                                        return file.id === id;
                                    });

                                    self.files.splice(index, 1);

                                    flash(
                                        self.lang('media-flash-deleted-message'),
                                        self.lang('media-flash-deleted-title')
                                    );
                                });
                        }
                    },
                    cancel: {
                        text: self.lang('cancel')
                    }
                }
            });
        },

        isPrimary (file) {
            return file.primary === 1;
        },

        lang (key, variables = '') {
            return window.lang(key, variables);
        },

        processFile (event) {
            const files = event.target.files || event.dataTransfer.files;

            if (!files.length) {
                return;
            }

            this.createFile(files[0]);
        },

        getFile (file) {
            return [
                window.Nova.baseUrl,
                'storage',
                'app',
                'public',
                pluralize(this.type),
                file.filename
            ].join('/');
        },

        makePrimary (id) {
            Nova.request().patch(route('media.update', { media: id }))
                .catch(() => {
                    flash(
                        this.lang('error-unauthorized-explain'),
                        this.lang('error-unauthorized'),
                        'error'
                    );
                });

            _.each(this.files, (file) => {
                if (file.id !== id) {
                    file.primary = 0;
                } else {
                    file.primary = 1;
                }
            });

            flash(
                this.lang('media-flash-primary-image-updated-message'),
                this.lang('media-flash-primary-image-updated-title')
            );
        },

        reset () {
            document.getElementById('file-upload').value = '';
            this.uploadedFile = '';
        },

        saveFile () {
            this.crop.result('canvas').then((canvas) => {
                Nova.request().post(route('media.store'), {
                    image: canvas,
                    location: pluralize(self.type),
                    id: this.item.id,
                    type: this.type
                }).then((response) => {
                    this.files.push(response.data);

                    flash(
                        this.lang('media-flash-saved-message'),
                        this.lang('media-flash-saved-title'),
                        'success'
                    );
                }).catch(() => {
                    flash(
                        this.lang('error-unauthorized-explain'),
                        this.lang('error-unauthorized'),
                        'error'
                    );
                });
            });

            this.reset();
        },

        showIcon (icon) {
            return window.icon(icon);
        }
    }
};
</script>
