<template>
    <sidebar-layout>
        <page-header :title="role.display_name">
            <template #pretitle>
                <inertia-link :href="route('roles.index')">Roles</inertia-link>
            </template>
        </page-header>

        <section class="panel">
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
                        <div class="form-section-header">Role info</div>
                        <p class="form-section-message">A role is a collection of permissions that allows a user to take certain actions throughout Nova. Since a user can have as many roles as you'd like, we recommend creating roles with fewer permissions to give yourself more freedom to add and remove access for a given user.</p>
                    </div>

                    <div class="form-section-column-form">
                        <form-field
                            label="Name"
                            field-id="display_name"
                            name="display_name"
                        >
                            <div class="field-group">
                                <input
                                    id="display_name"
                                    v-model="form.display_name"
                                    type="text"
                                    name="display_name"
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
                                >
                            </div>
                        </form-field>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">Permissions</div>
                        <p class="form-section-message">Permissions are the actions a signed in user can take throughout Nova. Feel free to add whatever permissions you want to this role.</p>
                    </div>

                    <div class="form-section-column-form">
                        <form-field>
                            <tags-input
                                v-model="permissions.added"
                                not-found-message="Sorry, no permissions found with that name."
                                placeholder="Add a permission..."
                                :search-url="route('permissions.search').url()"
                                display-property="display_name"
                                @add-item="addPermission"
                                @remove-item="removePermission"
                            ></tags-input>
                        </form-field>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">Users with this role</div>
                        <p class="form-section-message mb-6">This list shows the users who have been assigned this role. You can quickly add or remove users to the role from here.</p>

                        <p class="form-section-message"><span class="font-semibold text-warning-600">Take very special care when adding or removing roles from a user!</span></p>
                    </div>

                    <div class="form-section-column-form">
                        <form-field>
                            <tags-input
                                v-model="users.added"
                                not-found-message="Sorry, no users found with that name or email address."
                                placeholder="Add a user..."
                                :search-url="route('users.search').url()"
                                @add-item="addUser"
                                @remove-item="removeUser"
                            ></tags-input>
                        </form-field>
                    </div>
                </div>

                <div class="form-controls">
                    <button type="submit" class="button button-primary">Update Role</button>

                    <inertia-link :href="route('roles.index')" class="button">
                        Cancel
                    </inertia-link>
                </div>
            </form>
        </section>
    </sidebar-layout>
</template>

<script>
import findIndex from 'lodash/findIndex';
import debounce from 'lodash/debounce';
import axios from '@/Utils/axios';
import TagsInput from '@/Shared/TagsInput';

export default {
    components: { TagsInput },

    props: {
        role: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            form: {
                id: this.role.id,
                name: this.role.name,
                display_name: this.role.display_name
            },
            permissions: {
                added: this.role.permissions,
                results: [],
                search: ''
            },
            users: {
                added: this.role.users,
                results: [],
                search: ''
            }
        };
    },

    computed: {
        formData () {
            return {
                display_name: this.form.display_name,
                id: this.form.id,
                name: this.form.name,
                permissions: this.permissions.added.map(permission => permission.name),
                users: this.users.added.map(user => user.id)
            };
        }
    },

    watch: {
        'permissions.search': {
            handler: 'searchForPermissions'
        },
        'users.search': {
            handler: 'searchForUsers'
        }
    },

    methods: {
        addPermission (permission) {
            this.permissions.added.push(permission);

            this.permissions.results = [];
        },

        addUser (user) {
            this.users.added.push(user);

            this.users.results = [];
        },

        removePermission (permission) {
            const index = findIndex(
                this.permissions.added,
                p => p.name === permission.name
            );

            this.permissions.added.splice(index, 1);
        },

        removeUser (user) {
            const index = findIndex(
                this.users.added,
                u => u.id === user.id
            );

            this.users.added.splice(index, 1);
        },

        searchForPermissions: debounce(function () {
            const route = `${this.route('permissions.search')}?search=${this.permissions.search}`;

            axios.get(route).then(({ data }) => {
                this.permissions.results = data;
            });
        }, 250),

        searchForUsers: debounce(function () {
            const route = `${this.route('users.search')}?search=${this.users.search}`;

            axios.get(route).then(({ data }) => {
                this.users.results = data;
            });
        }, 250),

        submit () {
            this.$inertia.put(
                this.route('roles.update', { role: this.role }),
                this.formData
            );
        }
    }
};
</script>
