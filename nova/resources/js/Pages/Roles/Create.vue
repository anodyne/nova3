<template>
    <sidebar-layout>
        <page-header title="Create Role">
            <template #pretitle>
                <inertia-link :href="route('roles.index')">Roles</inertia-link>
            </template>
        </page-header>

        <section>
            <form
                :action="route('roles.store')"
                method="POST"
                role="form"
                @submit.prevent="submit"
            >
                <csrf-token></csrf-token>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">Role Info</div>
                        <p class="form-section-message">A role is a collection of abilities that allows users to take certain actions throughout Nova. Roles can be a combination of whatever abilities you'd like or can even be copied from existing roles.</p>
                    </div>

                    <div class="form-section-column-form">
                        <form-field
                            label="Name"
                            field-id="title"
                            name="title"
                        >
                            <div class="field-group">
                                <input
                                    id="title"
                                    v-model="form.title"
                                    type="text"
                                    name="title"
                                    class="field"
                                >
                            </div>
                        </form-field>

                        <form-field
                            label="Key"
                            field-id="name"
                            name="name"
                        >
                            <div class="field-group">
                                <input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    name="name"
                                    class="field"
                                    @change="suggestName = false"
                                >
                            </div>
                        </form-field>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">Abilities</div>
                        <p class="form-section-message">Abilities are the actions users can take. You can choose to copy the abilities from another role to start or you can choose to start fresh and add any abilities you want to this role.</p>
                    </div>

                    <div class="form-section-column-form">

                    </div>
                </div>

                <div class="form-controls">
                    <button type="submit" class="button is-primary is-large">Create</button>

                    <inertia-link :href="route('roles.index')" class="button is-secondary is-large">
                        Cancel
                    </inertia-link>
                </div>
            </form>
        </section>
    </sidebar-layout>
</template>

<script>
import slug from 'slug';
import axios from '@/Utils/axios';
import { Inertia } from 'inertia-vue';

export default {
    data () {
        return {
            form: {
                title: '',
                name: '',
                abilities: []
            },
            suggestName: true
        };
    },

    watch: {
        'form.title': function (newValue) {
            if (this.suggestName) {
                this.form.name = slug(newValue.toLowerCase());
            }
        }
    },

    methods: {
        submit () {
            axios.post(this.route('roles.store'), this.form)
                .then(() => {
                    Inertia.replace(this.route('roles.index'));
                })
                .catch((error) => {
                    console.error(error);
                });
        }
    }
};
</script>
