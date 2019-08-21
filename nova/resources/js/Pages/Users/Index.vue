<template>
    <sidebar-layout>
        <page-header title="Users">
            <inertia-link
                v-if="users.can.create"
                slot="controls"
                :href="route('users.create')"
                class="button is-primary"
            >
                Add User
            </inertia-link>
        </page-header>

        <section>
            <div class="mb-6 w-1/3">
                <div class="flex items-center py-1 px-2 rounded-full bg-white border-2 border-transparent text-gray-500 focus-within:bg-white focus-within:border-gray-400 focus-within:text-gray-600">
                    <icon name="search" class="mr-2"></icon>

                    <input
                        v-model="search"
                        type="text"
                        placeholder="Find a user..."
                        class="w-full appearance-none bg-transparent text-gray-800 focus:outline-none"
                    >

                    <a
                        v-show="search != ''"
                        role="button"
                        class="ml-2 text-gray-500 hover:text-danger-500"
                        @click="search = ''"
                    >
                        <icon name="close"></icon>
                    </a>
                </div>
            </div>

            <transition-group leave-active-class="animated fadeOut">
                <div
                    v-for="user in filteredUsers"
                    :key="user.id"
                    class="panel flex items-center justify-between"
                >
                    <div>
                        <user-avatar :user="user" size="sm"></user-avatar>
                    </div>

                    <div>
                        <dropdown placement="bottom-end">
                            <icon name="more-horizontal" class="h-6 w-6"></icon>

                            <template #dropdown="{ dropdownProps }">
                                <inertia-link
                                    v-if="user.can.update"
                                    :href="route('users.edit', { user })"
                                    class="dropdown-link"
                                >
                                    <icon name="edit" class="dropdown-item-icon"></icon>
                                    Edit
                                </inertia-link>
                                <a
                                    v-if="user.can.delete"
                                    role="button"
                                    class="dropdown-link-danger"
                                    @click="confirmRemove(user, dropdownProps)"
                                >
                                    <icon name="delete" class="dropdown-item-icon"></icon>
                                    Delete
                                </a>
                            </template>
                        </dropdown>
                    </div>
                </div>
            </transition-group>
        </section>

        <modal
            :open="modalIsShown"
            title="Delete Account"
            @close="hideModal"
        >
            Are you sure you want to delete <strong>{{ deletingItem.name }}</strong>'s account?

            <template #footer>
                <button class="button is-secondary" @click="hideModal">
                    Cancel
                </button>

                <button
                    type="button"
                    class="button is-danger-vivid ml-4"
                    @click="remove"
                >
                    Delete User
                </button>
            </template>
        </modal>
    </sidebar-layout>
</template>

<script>
import findIndex from 'lodash/findIndex';
import Form from '@/Utils/Form';
import UserAvatar from '@/Shared/Avatars/UserAvatar';
import ModalHelpers from '@/Utils/Mixins/ModalHelpers';

export default {
    components: { UserAvatar },

    mixins: [ModalHelpers],

    props: {
        pendingUsers: {
            type: Array,
            required: true
        },
        users: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            allUsers: this.users.data,
            form: new Form(),
            search: ''
        };
    },

    computed: {
        filteredUsers () {
            return this.allUsers.filter((user) => {
                const searchRegex = new RegExp(this.search, 'i');

                return searchRegex.test(user.name) || searchRegex.test(user.email);
            });
        }
    },

    methods: {
        confirmRemove (user, { toggle }) {
            toggle();
            this.showModal(user);
        },

        remove () {
            this.form.delete({
                url: this.route('users.destroy', { user: this.deletingItem }),
                then: (data) => {
                    this.hideModal();

                    const index = findIndex(this.allUsers, { id: data.id });

                    this.$toast.message(`User account for ${data.name} was removed.`).success();

                    this.allUsers.splice(index, 1);
                }
            });
        }
    }
};
</script>
