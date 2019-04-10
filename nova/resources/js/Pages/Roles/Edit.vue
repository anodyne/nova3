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
                        <p class="form-section-message">A role is a collection of abilities that allows a user to take certain actions throughout Nova. Since a user can have as many roles as you'd like, we recommend creating roles with fewer abilities to give yourself more freedom to add and remove permissions for a given user.</p>
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
                        <p class="form-section-message">Abilities are the actions a user can take. Feel free to add whatever abilities to this role that you see fit, but be careful with assigning the <em>All Abilities</em> item to your role!</p>
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
