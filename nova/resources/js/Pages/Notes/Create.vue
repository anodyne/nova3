<template>
    <admin-layout>
        <page-header title="Add Note">
            <template #pretitle>
                <inertia-link :href="$route('notes.index')">Notes</inertia-link>
            </template>
        </page-header>

        <panel>
            <form
                :action="$route('notes.store')"
                method="POST"
                role="form"
                data-cy="form"
                @submit.prevent="submit"
            >
                <csrf-token></csrf-token>

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
                    <button type="submit" class="button button-primary">Add Note</button>

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

    data () {
        return {
            form: {
                note: {
                    content: '',
                    source: ''
                },
                title: ''
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
            this.$inertia.post(this.$route('notes.store'), this.formData);
        }
    }
};
</script>
