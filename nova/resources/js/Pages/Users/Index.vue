<template>
    <sidebar-layout>
        <page-header title="Users">
            <inertia-link
                v-if="users.can.create"
                slot="controls"
                :href="route('users.create')"
                class="button is-primary"
            >
                Create User
            </inertia-link>
        </page-header>

        <section>
            <div class="mb-6 w-1/2">
                <div class="search-field">
                    <div class="field-addon">
                        <nova-icon name="search" class="h-5 w-5"></nova-icon>
                    </div>

                    <input
                        v-model="search"
                        type="text"
                        placeholder="Find a user..."
                        class="field"
                    >

                    <a
                        v-show="search != ''"
                        role="button"
                        class="field-addon"
                        @click="search = ''"
                    >
                        <nova-icon name="close" class="h-5 w-5"></nova-icon>
                    </a>
                </div>
            </div>

            <transition-group
                tag="div"
                class="data-table is-striped has-controls"
                leave-active-class="animated fadeOut"
            >
                <div key="header" class="row is-header">
                    <div class="col">
                        User Name
                    </div>
                </div>

                <div
                    v-for="user in filteredUsers"
                    :key="user.id"
                    class="row"
                >
                    <div class="col">
                        <user-avatar :user="user" size="sm"></user-avatar>
                    </div>
                    <div class="col-auto">
                        <dropdown placement="bottom-end">
                            <nova-icon name="more-vertical"></nova-icon>

                            <template #dropdown="{ dropdownProps }">
                                <inertia-link
                                    v-if="user.can.update"
                                    :href="route('users.edit', { user })"
                                    class="dropdown-link"
                                >
                                    <nova-icon name="edit" class="dropdown-item-icon"></nova-icon>
                                    Edit
                                </inertia-link>
                                <a
                                    v-if="user.can.delete"
                                    role="button"
                                    class="dropdown-link-danger"
                                    @click="confirmRemove(user, dropdownProps)"
                                >
                                    <nova-icon name="delete" class="dropdown-item-icon"></nova-icon>
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
            title="Delete account?"
            @close="hideModal"
        >
            Are you sure you want to delete {{ this.deletingItem.name }}'s account?

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
import Form from '@/Utils/Form';
import findIndex from 'lodash/findIndex';
import { Inertia } from 'inertia-vue';
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

                    this.$toast.message(`User account for ${user.name} was removed.`).success();

                    this.allUsers.splice(index, 1);
                }
            });
        }
    }
};
</script>
