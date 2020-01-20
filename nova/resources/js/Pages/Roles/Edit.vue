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
                        <p class="form-section-message mb-6">Permissions are the actions a user can take. Feel free to add whatever permissions to this role that you see fit.</p>
                    </div>

                    <div class="form-section-column-form">
                        <form-field label="Manage Permissions">
                            <div class="field-group">
                                <input
                                    v-model="searchPermissions"
                                    type="text"
                                    class="field"
                                    placeholder="Find a permission..."
                                >

                                <button
                                    v-show="searchPermissions !== ''"
                                    class="field-addon"
                                    @click.prevent="searchPermissions = ''"
                                >
                                    <icon name="close"></icon>
                                </button>
                            </div>
                        </form-field>

                        <toggle-switch v-model="showAssignedPermissionsOnly" class="my-4">
                            Show only assigned permissions
                        </toggle-switch>

                        <div
                            v-for="(permission, index) in filteredPermissions"
                            :key="permission.id"
                            class="flex items-center justify-between w-full p-2 rounded"
                            :class="{ 'bg-gray-200': index % 2 === 0 }"
                        >
                            <div class="text-gray-600">{{ permission.display_name }}</div>

                            <button
                                v-if="!hasPermission(permission)"
                                class="text-gray-500 hover:text-gray-600"
                                @click.prevent="addPermission(permission)"
                            >
                                <icon name="add"></icon>
                            </button>

                            <button
                                v-if="hasPermission(permission)"
                                class="text-success-500"
                                @click.prevent="removePermission(permission)"
                            >
                                <icon name="check-circle"></icon>
                            </button>
                        </div>
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
                            <!-- <div class="field-group">
                                <input
                                    v-model="searchUsers"
                                    type="text"
                                    class="field"
                                    placeholder="Find a user..."
                                >

                                <button
                                    v-show="searchUsers !== ''"
                                    class="field-addon"
                                    @click.prevent="searchUsers = ''"
                                >
                                    <icon name="close"></icon>
                                </button>
                            </div>
                        </form-field>

                        <toggle-switch v-model="showAssignedUsersOnly" class="my-4">
                            Show only users with this role
                        </toggle-switch> -->

                            <div class="flex items-center flex-wrap">
                                <div
                                    v-for="user in filteredUsers"
                                    :key="user.id"
                                    class="badge flex items-center mr-2 mt-3 py-1"
                                >
                                    <div class="text-gray-800 mr-2">{{ user.name }}</div>

                                    <button
                                        v-if="!hasUser(user)"
                                        class="text-gray-500 hover:text-gray-600"
                                        @click.prevent="addUser(user)"
                                    >
                                        <icon name="add"></icon>
                                    </button>

                                    <button
                                        v-if="hasUser(user)"
                                        class="text-gray-500"
                                        @click.prevent="removeUser(user)"
                                    >
                                        <icon name="close"></icon>
                                    </button>
                                </div>

                                <!-- <button class="flex items-center bg-info-200 text-info-600 rounded-full py-1 px-3 mt-3">
                                    <icon name="add"></icon>
                                </button> -->

                                <div class="inline-flex items-center bg-info-100 border-2 border-info-200 text-info-700 rounded-full py-1 px-3 mt-3 text-sm italic font-medium">
                                    <input
                                        type="text"
                                        class="appearance-none bg-transparent placeholder-info-700"
                                        placeholder="Find a user..."
                                    >
                                    <icon name="add" class="text-info-400"></icon>
                                </div>
                            </div>
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
import indexOf from 'lodash/indexOf';

export default {
    props: {
        permissions: {
            type: Array,
            required: true
        },
        role: {
            type: Object,
            required: true
        },
        users: {
            type: Array,
            required: true
        }
    },

    data () {
        return {
            form: {
                id: this.role.id,
                name: this.role.name,
                display_name: this.role.display_name,
                permissions: this.role.permissions.map(permission => permission.name),
                users: this.role.users.map(user => user.id)
            },
            searchPermissions: '',
            searchUsers: '',
            showAssignedPermissionsOnly: true,
            showAssignedUsersOnly: true
        };
    },

    computed: {
        filteredPermissions () {
            const permissions = (!this.showAssignedPermissionsOnly)
                ? this.permissions
                : this.permissions.filter(permission => this.hasPermission(permission));

            return permissions.filter((permission) => {
                const searchRegex = new RegExp(this.searchPermissions, 'i');

                return searchRegex.test(permission.name) || searchRegex.test(permission.display_name);
            });
        },

        filteredUsers () {
            const users = (!this.showAssignedUsersOnly)
                ? this.users
                : this.users.filter(user => this.hasUser(user));

            return users.filter((user) => {
                const searchRegex = new RegExp(this.searchUsers, 'i');

                return searchRegex.test(user.name) || searchRegex.test(user.email);
            });
        }
    },

    mounted () {
        if (this.role.permissions.length === 0) {
            this.showAssignedPermissionsOnly = false;
        }
    },

    methods: {
        addPermission (permission) {
            this.form.permissions.push(permission.name);
        },

        addUser (user) {
            this.form.users.push(user.id);
        },

        hasPermission (permission) {
            const name = (typeof permission === 'string')
                ? permission
                : permission.name;

            return indexOf(this.form.permissions, name) > -1;
        },

        hasUser (user) {
            return indexOf(this.form.users, user.id) > -1;
        },

        removePermission (permission) {
            const index = indexOf(this.form.permissions, permission.name);

            this.form.permissions.splice(index, 1);
        },

        removeUser (user) {
            const index = indexOf(this.form.users, user.id);

            this.form.users.splice(index, 1);
        },

        submit () {
            this.$inertia.put(
                this.route('roles.update', { role: this.role }),
                this.form
            );
        }
    }
};
</script>
