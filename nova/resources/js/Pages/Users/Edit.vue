<template>
    <admin-layout>
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
                data-cy="form"
                @submit.prevent="submit"
            >
                <csrf-token></csrf-token>
                <form-method put></form-method>

                <div class="form-section">
                    <div class="form-section-header">
                        <div class="form-section-header-title">User info</div>

                        <p class="form-section-header-message mb-6">For privacy reasons, we don't recommend using a user's real name. Instead, use a nickname to help protect their identity.</p>

                        <p class="form-section-header-message"><strong class="font-semibold">Note:</strong> you cannot manually update a user's password. If the user has forgotten their password, they should reset their password from the sign in page.</p>
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
                                >
                                    He/Him
                                </radio-button>
                                <radio-button
                                    id="female"
                                    v-model="form.gender"
                                    native-value="female"
                                    class="mx-6"
                                >
                                    She/Her
                                </radio-button>
                                <radio-button
                                    id="neutral"
                                    v-model="form.gender"
                                    native-value="neutral"
                                >
                                    They/Them
                                </radio-button>
                            </template>
                        </form-field>

                        <form-field label="Avatar">
                            <template #clean>
                                <div class="flex items-center">
                                    <avatar
                                        v-if="form.avatar === null"
                                        :image-url="user.avatar_url"
                                        size="lg"
                                    ></avatar>

                                    <img
                                        v-else
                                        ref="preview"
                                        class="avatar avatar-lg"
                                        data-cy="avatar-preview"
                                    >

                                    <div class="flex flex-col ml-4">
                                        <input
                                            id="image"
                                            ref="file"
                                            type="file"
                                            name="image"
                                            class="hidden"
                                            data-cy="upload"
                                            @change="setAvatar"
                                        >

                                        <div class="flex items-center">
                                            <button
                                                type="button"
                                                class="button button-soft button-small"
                                                data-cy="avatar-action-button"
                                                @click="$refs.file.click()"
                                            >
                                                <icon name="camera" class="mr-2"></icon>
                                                {{ avatarBrowseButtonLabel }}
                                            </button>

                                            <button
                                                v-if="showCancelAvatarChangeButton"
                                                type="button"
                                                class="text-gray-700 hover:text-gray-800 ml-4"
                                                @click="cancelAvatarChange"
                                            >
                                                Cancel
                                            </button>
                                        </div>

                                        <checkbox
                                            v-if="showRemoveOption"
                                            id="remove-avatar"
                                            v-model="form.remove_avatar"
                                            class="mt-2 ml-px"
                                            :native-value="true"
                                            data-cy="remove-avatar"
                                        >
                                            Remove avatar
                                        </checkbox>
                                    </div>
                                </div>
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
                        <form-field label="Assigned Role(s)">
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
                    <button type="submit" class="button button-primary">Update User</button>

                    <inertia-link :href="$route('users.index')" class="button">
                        Cancel
                    </inertia-link>
                </div>
            </form>
        </panel>

        <panel class="mt-8">
            <div class="py-4 px-4 | md:py-6 md:px-6">
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
            </div>
        </panel>
    </admin-layout>
</template>

<script>
import findIndex from 'lodash/findIndex';
import debounce from 'lodash/debounce';
import axios from '@/Utils/axios';
import TagsInput from '@/Shared/TagsInput';
import Avatar from '@/Shared/Avatar';
import Checkbox from '@/Shared/Forms/Checkbox';
import RadioButton from '@/Shared/Forms/RadioButton';

export default {
    components: {
        TagsInput, Avatar, Checkbox, RadioButton
    },

    props: {
        user: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            form: {
                name: this.user.name,
                email: this.user.email,
                gender: this.user.gender,
                avatar: null,
                remove_avatar: false
            },
            roles: {
                added: this.user.roles,
                results: [],
                search: ''
            }
        };
    },

    computed: {
        avatarBrowseButtonLabel () {
            if (this.user.has_avatar || this.form.avatar != null) {
                return 'Change Avatar';
            }

            return 'Add Avatar';
        },

        formData () {
            const data = new FormData();

            data.append('name', this.form.name);
            data.append('email', this.form.email);
            data.append('gender', this.form.gender);
            data.append('id', this.user.id);
            data.append('roles[]', this.roles.added.map(role => role.name));
            data.append('avatar', this.form.avatar || '');
            data.append('remove_avatar', this.form.remove_avatar ? '1' : '0');
            data.append('_method', 'put');

            return data;
        },

        showCancelAvatarChangeButton () {
            return this.form.avatar != null;
        },

        showRemoveOption () {
            return this.user.has_avatar;
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

        cancelAvatarChange () {
            this.form.avatar = null;
            this.$refs.file.value = '';
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

        removeExistingAvatar () {
            this.cancelAvatarChange();

            if (this.user.has_avatar) {
                this.form.remove_avatar = true;
            }
        },

        searchForRoles: debounce(function () {
            const route = `${this.$route('roles.search')}?search=${this.roles.search}`;

            axios.get(route).then(({ data }) => {
                this.roles.results = data;
            });
        }, 250),

        setAvatar (e) {
            this.form.avatar = e.target.files[0];

            const reader = new FileReader();

            reader.onload = (r) => {
                this.$refs.preview.src = r.target.result;
            };

            reader.readAsDataURL(this.form.avatar);
        },

        submit () {
            this.$inertia.post(
                this.$route('users.update', { user: this.user }),
                this.formData
            ).then(() => {
                if (Object.keys(this.$page.errors).length === 0) {
                    this.form.avatar = null;
                    this.form.remove_avatar = false;
                }
            });
        }
    }
};
</script>
