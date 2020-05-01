<template>
    <admin-layout>
        <page-header :title="note.title">
            <template #pretitle>
                <inertia-link :href="$route('notes.index')">Notes</inertia-link>
            </template>
        </page-header>

        <panel>
            <form
                :action="$route('notes.update', { note })"
                method="POST"
                role="form"
                @submit.prevent="submit"
            >
                <csrf-token></csrf-token>
                <form-method put></form-method>

                <div class="px-4 pt-4 | sm:pt-6 sm:px-6">
                    <form-field
                        label="Title"
                        field-id="title"
                        name="title"
                        class="sm:w-1/2"
                    >
                        <input
                            id="title"
                            v-model="form.title"
                            type="text"
                            name="title"
                            class="field"
                            data-cy="title"
                        >
                    </form-field>

                    <form-field
                        label="Content"
                        field-id="content"
                        name="content"
                    >
                        <template #clean>
                            <simple-editor v-model="form.note" height="min-h-48"></simple-editor>
                        </template>
                    </form-field>
                </div>

                <div class="form-footer">
                    <button type="submit" class="button button-primary">Update Note</button>

                    <inertia-link :href="$route('notes.index')" class="button">
                        Cancel
                    </inertia-link>
                </div>
            </form>
        </panel>
    </admin-layout>
</template>

<script>
import SimpleEditor from '@/Shared/Editors/SimpleEditor';

export default {
    components: { SimpleEditor },

    props: {
        note: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            form: {
                note: {
                    content: this.note.content,
                    source: this.note.source
                },
                title: this.note.title
            }
        };
    },

    computed: {
        formData () {
            return {
                title: this.form.title,
                source: this.form.note.source,
                content: this.form.note.content
            };
        }
    },

    methods: {
        submit () {
            this.$inertia.put(
                this.$route('notes.update', { note: this.note }),
                this.formData
            );
        }
    }
};
</script>
