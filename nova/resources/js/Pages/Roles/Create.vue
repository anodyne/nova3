<template>
    <sidebar-layout>
        <page-header title="Add a Role">
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
                        <p class="form-section-message">Permissions are the actions a signed in user can take throughout the site. Feel free to add whatever permissions to this role that you want.</p>
                    </div>

                    <div class="form-section-column-form">
                        <div class="flex items-center flex-wrap">
                            <div
                                v-for="permission in permissions.added"
                                :key="permission.id"
                                class="badge flex items-center mr-2 mt-3 py-1"
                            >
                                <div class="text-gray-800 mr-2">{{ permission.display_name }}</div>

                                <button
                                    v-if="hasPermission(permission)"
                                    class="text-gray-500"
                                    @click.prevent="removePermission(permission)"
                                >
                                    <icon name="close"></icon>
                                </button>
                            </div>

                            <button class="button button-icon button-bg button-info-soft rounded-full px-3 mt-3">
                                <icon name="add"></icon>
                            </button>

                            <div class="inline-flex items-center bg-info-100 border-2 border-info-200 text-info-700 rounded-full py-1 px-3 mt-3 text-sm italic font-medium">
                                <input
                                    v-model="permissions.search"
                                    type="text"
                                    class="appearance-none bg-transparent placeholder-info-700 outline-none"
                                    placeholder="Find a permission..."
                                >
                                <icon name="add" class="text-info-400"></icon>
                            </div>
                        </div>

                        <div v-if="permissions.results.length > 0" class="absolute rounded bg-gray-900 opacity-75 text-gray-300 mt-1 w-auto">
                            <button
                                v-for="permission in permissions.results"
                                :key="permission.id"
                                class="flex py-1 px-3 cursor-pointer"
                                @click.prevent="addPermission(permission)"
                            >
                                {{ permission.display_name }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">Give users this role</div>
                        <p class="form-section-message">You can quickly add users to the role you're creating from here.</p>
                    </div>

                    <div class="form-section-column-form">
                        <div class="flex items-center flex-wrap">
                            <div
                                v-for="user in users.added"
                                :key="user.id"
                                class="badge flex items-center mr-2 mt-3 py-1"
                            >
                                <div class="text-gray-800 mr-2">{{ user.name }}</div>

                                <button
                                    v-if="hasUser(user)"
                                    class="text-gray-500"
                                    @click.prevent="removeUser(user)"
                                >
                                    <icon name="close"></icon>
                                </button>
                            </div>

                            <button class="button button-icon button-bg button-info-soft rounded-full px-3 mt-3">
                                <icon name="add"></icon>
                            </button>

                            <div class="inline-flex items-center bg-info-100 border-2 border-info-200 text-info-700 rounded-full py-1 px-3 mt-3 text-sm italic font-medium">
                                <input
                                    v-model="users.search"
                                    type="text"
                                    class="appearance-none bg-transparent placeholder-info-700 outline-none"
                                    placeholder="Find a user..."
                                >
                                <icon name="add" class="text-info-400"></icon>
                            </div>
                        </div>

                        <div v-if="users.results.length > 0" class="absolute rounded bg-gray-900 opacity-75 text-gray-300 mt-1 w-auto">
                            <button
                                v-for="user in users.results"
                                :key="user.id"
                                class="flex py-1 px-3 cursor-pointer"
                                @click.prevent="addUser(user)"
                            >
                                {{ user.name }}
                            </button>
                        </div>
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
import indexOf from 'lodash/indexOf';
import debounce from 'lodash/debounce';
import axios from '@/Utils/axios';

export default {
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
            this.users.added.push(user.id);
        },

        hasPermission (permission) {
            return indexOf(this.permissions.added, permission.name) > -1;
        },

        hasUser (user) {
            return indexOf(this.users.added, user.id) > -1;
        },

        removePermission (permission) {
            const index = indexOf(this.permissions.added, permission.name);

            this.permissions.added.splice(index, 1);
        },

        removeUser (user) {
            const index = indexOf(this.users.added, user.id);

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
