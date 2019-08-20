<template>
    <sidebar-layout>
        <page-header :title="user.name">
            <template #pretitle>
                <inertia-link :href="route('users.index')">Users</inertia-link>
            </template>
        </page-header>

        <section>
            <form
                :action="route('users.update', { user })"
                method="POST"
                role="form"
                @submit.prevent="submit"
            >
                <csrf-token></csrf-token>
                <form-method put></form-method>

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

                        <form-field label="Avatar">
                            <div class="avatar avatar-lg items-center">
                                <div class="avatar-image">
                                    <a role="button" class="absolute inset-0 flex justify-center items-center rounded-full transition-fast text-transparent hover:text-gray-100">
                                        <icon name="edit"></icon>
                                    </a>
                                </div>

                                <a role="button" class="button is-danger is-small ml-2">
                                    <icon name="trash" class="mr-2"></icon>
                                    Remove Image
                                </a>
                            </div>
                        </form-field>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">Roles</div>
                        <p class="form-section-message mb-6">Roles are made up of the abilities that users can take throughout the system. A user can be assigned as many roles as you'd like to give you more control over the actions your users can take.</p>

                        <inertia-link :href="route('roles.index')" class="text-primary-600 hover:text-primary-500">
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
                                    <icon name="close"></icon>
                                </a>
                            </div>
                        </form-field>

                        <toggle-switch
                            v-model="showAssignedRolesOnly"
                            small
                            class="mb-4"
                        >
                            Show only assigned roles
                        </toggle-switch>

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
                                <icon name="add"></icon>
                            </a>

                            <a
                                v-if="hasRole(role)"
                                role="button"
                                class="text-success-500"
                                @click="removeRole(role)"
                            >
                                <icon name="check-circle"></icon>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="form-controls">
                    <button type="submit" class="button is-primary">Update</button>

                    <inertia-link :href="route('users.index')" class="button is-secondary">
                        Cancel
                    </inertia-link>
                </div>
            </form>
        </section>

        <section>
            <div class="font-semibold text-xl mb-4 text-gray-700">Reset Password</div>

            <p class="text-gray-600">If you believe a user should reset their password or they're having issues logging in and are unable to reset their password themselves, you can force a password reset that will take effect next time they attempt to sign in.</p>

            <div class="flex justify-end mt-6">
                <a role="button" class="button is-danger is-large">
                    Force Password Reset
                </a>
            </div>
        </section>
    </sidebar-layout>
</template>

<script>
import UserHelpers from './UserHelpers';
import Form from '@/Utils/Form';

export default {
    mixins: [UserHelpers],

    props: {
        user: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            form: new Form({
                name: this.user.name,
                email: this.user.email,
                roles: this.user.roles
            }),
            search: '',
            showAssignedRolesOnly: true
        };
    },

    computed: {
        filteredRoles () {
            const roles = (!this.showAssignedRolesOnly)
                ? this.roles
                : this.roles.filter(role => this.hasRole(role));

            return roles.filter((role) => {
                const searchRegex = new RegExp(this.search, 'i');

                return searchRegex.test(role.name) || searchRegex.test(role.title);
            });
        }
    },

    methods: {
        submit () {
            this.form.post({
                url: this.route('users.update', { user: this.user }),
                then: (data) => {
                    this.$toast.message(`User account for ${data.name} was updated.`).success();

                    this.$inertia.replace(this.route('users.index'));
                }
            });
        }
    }
};
</script>
