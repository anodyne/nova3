<template>
    <sidebar-layout>
        <page-header slot="header" title="Users"></page-header>

        <div class="flex flex-col bg-white -mt-8 -mx-12 mb-8 py-2 px-8">
            <div class="w-full border-t mb-4"></div>
            <div class="flex items-center tracking-wide">
                <div class="font-semibold text-gray-700 mr-8">Active</div>
                <div class="flex items-center text-gray-600">Pending <div class="badge badge-info ml-2">4</div></div>
            </div>
        </div>

        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center w-1/2 p-2 rounded bg-white border text-gray-500 focus-within:border-primary-300 focus-within:text-primary-500">
                <div class="mr-2 flex-shrink-0">
                    <icon name="search" class="h-5 w-5"></icon>
                </div>

                <input
                    v-model="search"
                    type="text"
                    placeholder="Find a user..."
                    class="appearance-none flex-auto text-gray-800 focus:outline-none"
                >

                <a
                    role="button"
                    class="text-gray-600"
                    @click="search = ''"
                >
                    <icon name="close" class="h-5 w-5"></icon>
                </a>
            </div>

            <inertia-link
                v-if="users.can.create"
                slot="controls"
                :href="route('users.create')"
                class="button is-primary my-0"
            >
                Add User
            </inertia-link>
        </div>

        <section
            v-for="user in filteredUsers"
            :key="user.id"
            class="flex items-center justify-between bg-gray-700 rounded p-6 overflow-hidden shadow-md mt-6 first:mt-0"
        >
            <div class="flex items-center">
                <user-avatar :user="user" size="sm"></user-avatar>

                <div class="badge badge-success">Active</div>

                <div class="badge badge-warning">Pending</div>

                <div class="badge badge-info">Live</div>
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
        </section>

        <modal
            :open="modalIsShown"
            title="Delete Account"
            @close="hideModal"
        >
            Are you sure you want to delete <strong>{{ deletingItem.name }}</strong>'s account?

            <template #footer>
                <button
                    type="button"
                    class="button is-danger-vivid mr-4"
                    @click="remove"
                >
                    Delete
                </button>

                <button class="button is-secondary" @click="hideModal">
                    Cancel
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
