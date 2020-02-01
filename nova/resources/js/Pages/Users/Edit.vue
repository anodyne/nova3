<template>
    <sidebar-layout>
        <page-header :title="user.name">
            <template #pretitle>
                <inertia-link :href="$route('users.index')">Users</inertia-link>
            </template>
        </page-header>

        <panel>
            <form
                :action="$route('users.update', { user })"
                method="POST"
                role="form"
                @submit.prevent="submit"
            >
                <csrf-token></csrf-token>
                <form-method put></form-method>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">User info</div>

                        <p class="form-section-message mb-6">For privacy reasons, we don't recommend using a user's real name. Instead, use a nickname to help protect their identity.</p>

                        <p class="form-section-message">For security reasons, you cannot manually update a user's password. If the user has forgotten their password, they should reset their password from the sign page.</p>
                    </div>

                    <div class="form-section-column-form">
                        <form-field
                            label="Nickname"
                            field-id="nickname"
                            name="nickname"
                        >
                            <div class="field-group">
                                <input
                                    id="nickname"
                                    v-model="form.nickname"
                                    type="text"
                                    name="nickname"
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
                                    v-model="form.email"
                                    type="email"
                                    name="email"
                                    class="field"
                                >
                            </div>
                        </form-field>

                        <div class="my-8">
                            <label class="field-label">Avatar</label>

                            <div class="flex items-center">
                                <avatar :image-url="user.avatar_url" size="lg"></avatar>

                                <button type="button" class="button button-soft button-small ml-4">
                                    Change
                                </button>

                                <button type="button" class="button button-soft button-text ml-4">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">Roles</div>
                        <p class="form-section-message mb-6">Roles are made up of the actions a user can take throughout Nova. A user can be assigned as many roles as you'd like to give you more granular control over the actions they can perform.</p>

                        <inertia-link :href="$route('roles.index')" class="button button-primary button-text">
                            Manage roles
                        </inertia-link>
                    </div>

                    <div class="form-section-column-form">
                        <form-field label="Assigned Role(s)">
                            <tags-input
                                v-model="roles.added"
                                not-found-message="Sorry, no roles found with that name."
                                placeholder="Add a role..."
                                :search-url="$route('roles.search').url()"
                                display-property="display_name"
                                @add-item="addRole"
                                @remove-item="removeRole"
                            ></tags-input>
                        </form-field>
                    </div>
                </div>

                <div class="form-controls">
                    <button type="submit" class="button button-primary">Update User</button>

                    <inertia-link :href="$route('users.index')" class="button">
                        Cancel
                    </inertia-link>
                </div>
            </form>
        </panel>

        <panel>
            <div class="font-semibold text-xl mb-4 text-gray-700">Reset Password</div>

            <p class="text-gray-600">If you believe this user should be forced to reset their password, you can force a password reset that will prompt them to change their password the next time they attempt to sign in.</p>

            <div class="flex justify-end mt-6">
                <button
                    type="button"
                    class="button button-primary-soft"
                    @click.prevent="forcePasswordReset"
                >
                    Force Password Reset
                </button>
            </div>
        </panel>
    </sidebar-layout>
</template>

<script>
import findIndex from 'lodash/findIndex';
import debounce from 'lodash/debounce';
import axios from '@/Utils/axios';
import TagsInput from '@/Shared/TagsInput';
import Avatar from '@/Shared/Avatars/Avatar';

export default {
    components: { TagsInput, Avatar },

    props: {
        user: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            form: {
                nickname: this.user.nickname,
                email: this.user.email
            },
            roles: {
                added: this.user.roles,
                results: [],
                search: ''
            }
        };
    },

    computed: {
        formData () {
            return {
                nickname: this.form.nickname,
                id: this.form.id,
                email: this.form.email,
                roles: this.roles.added.map(role => role.name)
            };
        }
    },

    watch: {
        'roles.search': 'searchForRoles'
    },

    methods: {
        addRole (role) {
            this.roles.added.push(role);

            this.roles.results = [];
        },

        forcePasswordReset () {
            this.$inertia.put(
                this.$route('users.force-password-reset', { user: this.user })
            );
        },

        removeRole (role) {
            const index = findIndex(
                this.roles.added,
                r => r.name === role.name
            );

            this.roles.added.splice(index, 1);
        },

        searchForRoles: debounce(function () {
            const route = `${this.$route('roles.search')}?search=${this.roles.search}`;

            axios.get(route).then(({ data }) => {
                this.roles.results = data;
            });
        }, 250),

        submit () {
            this.$inertia.put(
                this.$route('users.update', { user: this.user }),
                this.formData
            );
        }
    }
};
</script>
