<template>
    <sidebar-layout>
        <page-header title="Create User">
            <template #pretitle>
                <inertia-link :href="route('users.index')">Users</inertia-link>
            </template>
        </page-header>

        <section>
            <form
                :action="route('users.store')"
                method="POST"
                role="form"
                @submit.prevent="submit"
            >
                <csrf-token></csrf-token>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">User Info</div>
                        <p class="form-section-message mb-6">For privacy reasons, we don't recommend using a user's real name. Instead, you can use a nickname to help protect their identity.</p>
                        <p class="form-section-message">For security reasons, you cannot specify the password for a user. After the account is created, a password will be generated and emailed to them.</p>
                    </div>

                    <div class="form-section-column-form">
                        <form-field
                            label="Name"
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

                        <form-field
                            label="Email Address"
                            field-id="email"
                            name="email"
                        >
                            <div class="field-group">
                                <input
                                    id="email"
                                    v-model="form.fields.email"
                                    type="email"
                                    name="email"
                                    class="field"
                                >
                            </div>
                        </form-field>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">Roles</div>
                        <p class="form-section-message mb-6">Roles are made up of the abilities that users can take throughout the system. A user can be assigned as many roles as you'd like to give you more control over the actions your users can take.</p>

                        <inertia-link :href="route('roles.index')" class="text-blue-600 hover:text-blue-500">
                            Manage roles
                        </inertia-link>
                    </div>

                    <div class="form-section-column-form">
                        <form-field label="Assign Roles">
                            <div class="field-group">
                                <input
                                    v-model="search"
                                    type="text"
                                    class="field"
                                    placeholder="Find a role..."
                                >

                                <a
                                    v-show="search !== ''"
                                    role="button"
                                    class="field-addon"
                                    @click="search = ''"
                                >
                                    <nova-icon name="close"></nova-icon>
                                </a>
                            </div>
                        </form-field>

                        <div
                            v-for="(role, index) in filteredRoles"
                            :key="role.id"
                            class="flex items-center justify-between w-full p-2 rounded"
                            :class="{ 'bg-gray-200': index % 2 === 0 }"
                        >
                            <div class="text-gray-600">{{ role.title }}</div>

                            <a
                                v-if="!hasRole(role)"
                                role="button"
                                class="text-gray-500 hover:text-gray-600"
                                @click="addRole(role)"
                            >
                                <nova-icon name="add"></nova-icon>
                            </a>

                            <a
                                v-if="hasRole(role)"
                                role="button"
                                class="text-green-500"
                                @click="removeRole(role)"
                            >
                                <nova-icon name="check-circle"></nova-icon>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="form-controls">
                    <button type="submit" class="button is-primary is-large">Create</button>

                    <inertia-link :href="route('users.index')" class="button is-secondary is-large">
                        Cancel
                    </inertia-link>
                </div>
            </form>
        </section>
    </sidebar-layout>
</template>

<script>
import { Inertia } from 'inertia-vue';
import UserHelpers from './UserHelpers';
import Form from '@/Utils/Form';

export default {
    mixins: [UserHelpers],

    data () {
        return {
            form: new Form({
                name: '',
                email: '',
                roles: []
            }),
            search: ''
        };
    },

    computed: {
        filteredRoles () {
            return this.roles.filter((role) => {
                const searchRegex = new RegExp(this.search, 'i');

                return searchRegex.test(role.name) || searchRegex.test(role.title);
            });
        }
    },

    methods: {
        submit () {
            this.form.post({
                url: this.route('users.store'),
                then: (data) => {
                    this.$toast.message(`User account for ${data.name} was created.`).success();

                    Inertia.replace(this.route('users.index'));
                }
            });
        }
    }
};
</script>
