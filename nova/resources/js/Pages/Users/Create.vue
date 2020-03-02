<template>
    <admin-layout>
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
                data-cy="form"
                @submit.prevent="submit"
            >
                <csrf-token></csrf-token>

                <div class="form-section">
                    <div class="form-section-header">
                        <div class="form-section-header-title">User info</div>
                        <p class="form-section-header-message mb-6">For privacy reasons, we don't recommend using a user's real name. Instead, use a nickname to help protect their identity.</p>
                        <p class="form-section-header-message"><strong class="font-semibold">Note:</strong> after the account is created, a password will be generated and emailed to the new user.</p>
                    </div>

                    <div class="form-section-content">
                        <form-field
                            label="Name"
                            field-id="name"
                            name="name"
                        >
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                name="name"
                                class="field"
                                data-cy="name"
                            >
                        </form-field>

                        <form-field
                            label="Email"
                            field-id="email"
                            name="email"
                        >
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                name="email"
                                class="field"
                                data-cy="email"
                            >
                        </form-field>

                        <form-field
                            label="Preferred pronouns"
                            field-id="gender"
                            name="gender"
                        >
                            <template #clean>
                                <radio-button
                                    id="male"
                                    v-model="form.gender"
                                    native-value="male"
                                    name="gender"
                                >
                                    He/Him
                                </radio-button>
                                <radio-button
                                    id="female"
                                    v-model="form.gender"
                                    native-value="female"
                                    class="mx-6"
                                    name="gender"
                                >
                                    She/Her
                                </radio-button>
                                <radio-button
                                    id="neutral"
                                    v-model="form.gender"
                                    native-value="neutral"
                                    name="gender"
                                >
                                    They/Them
                                </radio-button>
                            </template>
                        </form-field>
                    </div>
                </div>

                <div class="form-section">
                    <div class="form-section-header">
                        <div class="form-section-header-title">Roles</div>

                        <p class="form-section-header-message">Roles are made up of the actions a user can take throughout Nova. A user can be assigned as many roles as you'd like to give you more granular control over the actions they can perform.</p>

                        <inertia-link
                            v-if="user.can.manageRoles"
                            :href="$route('roles.index')"
                            class="button button-soft button-sm mt-6"
                        >
                            Manage roles
                        </inertia-link>
                    </div>

                    <div class="form-section-content">
                        <form-field label="Assign Role(s)">
                            <template #clean>
                                <tags-input
                                    v-model="roles.added"
                                    not-found-message="Sorry, no roles found with that name."
                                    placeholder="Add a role..."
                                    :search-url="$route('roles.search').url()"
                                    display-property="display_name"
                                    @add-item="addRole"
                                    @remove-item="removeRole"
                                ></tags-input>
                            </template>
                        </form-field>
                    </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="button button-primary">Add User</button>

                    <inertia-link :href="$route('users.index')" class="button">
                        Cancel
                    </inertia-link>
                </div>
            </form>
        </panel>
    </admin-layout>
</template>

<script>
import findIndex from 'lodash/findIndex';
import debounce from 'lodash/debounce';
import axios from '@/Utils/axios';
import TagsInput from '@/Shared/TagsInput';
import RadioButton from '@/Shared/Forms/RadioButton';

export default {
    components: { TagsInput, RadioButton },

    props: {
        user: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            form: {
                name: '',
                email: '',
                gender: ''
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
                name: this.form.name,
                email: this.form.email,
                gender: this.form.gender,
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
