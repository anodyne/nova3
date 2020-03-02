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

                <div class="form-section">
                    <div class="form-section-header">
                        <div class="form-section-header-title">Role info</div>
                        <p class="form-section-header-message">A role is a collection of permissions that allows a user to take certain actions throughout Nova. Since a user can have as many roles as you'd like, we recommend creating roles with fewer permissions to give yourself more freedom to add and remove access for a given user.</p>
                    </div>

                    <div class="form-section-content">
                        <form-field
                            label="Title"
                            field-id="title"
                            name="title"
                        >
                            <input
                                id="title"
                                v-model="form.title"
                                type="text"
                                name="title"
                                class="field"
                            >
                        </form-field>

                        <form-field
                            label="Content"
                            field-id="content"
                            name="content"
                        >
                            <textarea
                                id="content"
                                v-model="form.content"
                                name="content"
                                class="field"
                                rows="10"
                            ></textarea>
                        </form-field>
                    </div>
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
import slug from 'slug';
import findIndex from 'lodash/findIndex';
import debounce from 'lodash/debounce';
import axios from '@/Utils/axios';

export default {
    props: {
        note: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            form: {
                content: this.note.content,
                title: this.note.title
            }
        };
    },

    computed: {
        formData () {
            return {
                title: this.form.title,
                content: this.form.content
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
