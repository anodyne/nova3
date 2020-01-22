<template>
    <sidebar-layout>
        <page-header title="Add Role">
            <template #pretitle>
                <inertia-link :href="route('roles.index')">Roles</inertia-link>
            </template>
        </page-header>

        <section class="panel">
            <form
                :action="route('roles.store')"
                method="POST"
                role="form"
                @submit.prevent="submit"
            >
                <csrf-token></csrf-token>

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
                                    @change="suggestName = false"
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
                        <div class="form-section-header">Give users this role</div>
                        <p class="form-section-message">You can quickly add users to this role from here.</p>
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
                    <button type="submit" class="button button-primary">Add Role</button>

                    <inertia-link :href="route('roles.index')" class="button button-soft">
                        Cancel
                    </inertia-link>
                </div>
            </form>
        </section>
    </sidebar-layout>
</template>

<script>
import slug from 'slug';
import findIndex from 'lodash/findIndex';
import debounce from 'lodash/debounce';
import axios from '@/Utils/axios';
import TagsInput from '@/Shared/TagsInput';

export default {
    components: { TagsInput },

    data () {
        return {
            form: {
                display_name: '',
                name: ''
            },
            permissions: {
                added: [],
                results: [],
                search: ''
            },
            suggestName: true,
            users: {
                added: [],
                results: [],
                search: ''
            }
        };
    },

    computed: {
        formData () {
            return {
                display_name: this.form.display_name,
                name: this.form.name,
                permissions: this.permissions.added.map(permission => permission.name),
                users: this.users.added.map(user => user.id)
            };
        }
    },

    watch: {
        'form.display_name': function (newValue) {
            if (this.suggestName) {
                this.form.name = slug(newValue.toLowerCase());
            }
        },
        'permissions.search': {
            handler: 'searchForPermissions',
            deep: true
        },
        'users.search': {
            handler: 'searchForUsers',
            deep: true
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
            this.$inertia.post(this.route('roles.store'), this.formData);
        }
    }
};
</script>
