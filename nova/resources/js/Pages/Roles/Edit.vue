<template>
    <sidebar-layout>
        <page-header :title="role.title">
            <template #pretitle>
                <inertia-link :href="route('roles.index')">Roles</inertia-link>
            </template>
        </page-header>

        <section>
            <form
                :action="route('roles.update', { role })"
                method="POST"
                role="form"
                @submit.prevent="submit"
            >
                <csrf-token></csrf-token>
                <form-method put></form-method>

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
                                    v-model="form.fields.title"
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
                                    v-model="form.fields.name"
                                    type="text"
                                    name="name"
                                    class="field"
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
import Form from '@/Utils/Form';
import { Inertia } from 'inertia-vue';

export default {
    props: {
        role: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            form: new Form({
                name: this.role.name,
                title: this.role.title,
                abilities: []
            })
        };
    },

    methods: {
        submit () {
            this.form.put({
                url: this.route('roles.update', { role: this.role }),
                then: (data) => {
                    this.$toast.message(`${data.title} role was updated.`).success();

                    Inertia.replace(this.route('roles.index'));
                }
            });
        }
    }
};
</script>
