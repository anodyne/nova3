<template>
    <sidebar-layout>
        <page-header title="Add User">
            <template #pretitle>
                <inertia-link :href="$route('users.index')">Users</inertia-link>
            </template>
        </page-header>

        <panel>
            <form
                :action="$route('users.store')"
                method="POST"
                role="form"
                @submit.prevent="submit"
            >
                <csrf-token></csrf-token>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">User info</div>

                        <p class="form-section-message mb-6">For privacy reasons, we don't recommend using a user's real name. Instead, use a nickname to help protect their identity.</p>

                        <p class="form-section-message">For security reasons, you cannot specify the password for a new user. After the account is created, a password will be generated and emailed to them.</p>
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
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-column-content">
                        <div class="form-section-header">Roles</div>

                        <p class="form-section-message">Roles are made up of the actions a user can take throughout Nova. A user can be assigned as many roles as you'd like to give you more granular control over the actions they can perform.</p>

                        <inertia-link
                            :href="$route('roles.index')"
                            class="button button-primary button-text mt-6"
                        >
                            Manage roles
                        </inertia-link>
                    </div>

                    <div class="form-section-column-form">
                        <form-field label="Assign Role(s)">
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
                    <button type="submit" class="button button-primary">Add User</button>

                    <inertia-link :href="$route('users.index')" class="button">
                        Cancel
                    </inertia-link>
                </div>
            </form>
        </panel>
    </sidebar-layout>
</template>

<script>
import findIndex from 'lodash/findIndex';
import debounce from 'lodash/debounce';
import axios from '@/Utils/axios';
import TagsInput from '@/Shared/TagsInput';

export default {
    components: { TagsInput },

    data () {
        return {
            form: {
                nickname: '',
                email: ''
            },
            roles: {
                added: [],
                results: [],
                search: ''
            }
        };
    },

    computed: {
        formData () {
            return {
                nickname: this.form.nickname,
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
            this.$inertia.post(this.$route('users.store'), this.formData);
        }
    }
};
</script>
