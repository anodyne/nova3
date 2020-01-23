<template>
    <admin-layout>
        <page-header title="Users">
            <inertia-link
                v-if="users.can.create"
                slot="controls"
                :href="route('users.create')"
                class="button button-primary"
            >
                Add User
            </inertia-link>
        </page-header>

        <!-- <section>
            <div class="mb-6 w-1/3">
                <search-filter
                    v-model="form.search"
                    placeholder="Find a user..."
                    @reset="form.search = ''"
                ></search-filter>
            </div>

            <div
                v-for="user in users.data"
                :key="user.id"
                class="panel flex items-center justify-between"
            >
                <div>
                    <user-avatar :user="user" size="sm"></user-avatar>
                </div>

                <div>
                    <dropdown placement="bottom-end">
                        <icon name="more-horizontal" class="h-6 w-6"></icon>

                        <template #dropdown="{ toggle }">
                            <inertia-link
                                v-if="user.can.update"
                                :href="route('users.edit', { user })"
                                class="dropdown-link"
                            >
                                <icon name="edit" class="dropdown-icon"></icon>
                                Edit
                            </inertia-link>
                            <a
                                v-if="user.can.delete"
                                role="button"
                                class="dropdown-link-danger"
                                @click="confirmRemove(user, toggle)"
                            >
                                <icon name="delete" class="dropdown-icon"></icon>
                                Delete
                            </a>
                        </template>
                    </dropdown>
                </div>
            </div>

            <pagination :links="users.links"></pagination>
        </section> -->

        <section>
            <div class="rounded overflow-hidden bg-white shadow-md">
                <div class="flex items-center py-3 px-6">
                    <button class="button button-soft button-icon">
                        <icon name="filter"></icon>
                    </button>
                </div>

                <div>
                    <div class="flex items-center justify-between w-full py-2 px-6 bg-gray-100 border-t border-b text-xs uppercase tracking-wide font-medium text-gray-600">
                        <div>Name</div>
                        <div>Column</div>
                        <div>Column</div>
                        <div>Column</div>
                    </div>

                    <div
                        v-for="user in users.data"
                        :key="user.id"
                        class="flex items-center justify-between w-full py-3 px-6 border-b odd:bg-gray-100"
                    >
                        <div>
                            <user-avatar :user="user" size="sm"></user-avatar>
                        </div>

                        <div>
                            <div class="badge badge-info">Inactive</div>
                        </div>

                        <div>
                            <dropdown placement="bottom-end">
                                <icon name="more-horizontal" class="h-6 w-6"></icon>

                                <template #dropdown="{ toggle }">
                                    <inertia-link
                                        v-if="user.can.update"
                                        :href="route('users.edit', { user })"
                                        class="dropdown-link"
                                    >
                                        <icon name="edit" class="dropdown-icon"></icon>
                                        Edit
                                    </inertia-link>
                                    <a
                                        v-if="user.can.delete"
                                        role="button"
                                        class="dropdown-link-danger"
                                        @click="confirmRemove(user, toggle)"
                                    >
                                        <icon name="delete" class="dropdown-icon"></icon>
                                        Delete
                                    </a>
                                </template>
                            </dropdown>
                        </div>
                    </div>

                    <!-- <div class="flex items-center justify-between w-full py-3 px-6">
                        <div>Active User</div>
                        <div>Column</div>
                        <div>Column</div>
                        <div>Column</div>
                    </div>
                    <div class="flex items-center justify-between w-full py-3 px-6 bg-gray-100">
                        <div>System Admin</div>
                        <div>Column</div>
                        <div>Column</div>
                        <div>Column</div>
                    </div> -->
                    <!-- <div class="flex items-center justify-between w-full py-3 px-6">
                        <div>Column</div>
                        <div>Column</div>
                        <div>Column</div>
                        <div>Column</div>
                    </div>
                    <div class="flex items-center justify-between w-full py-3 px-6 bg-gray-100">
                        <div>Column</div>
                        <div>Column</div>
                        <div>Column</div>
                        <div>Column</div>
                    </div>
                    <div class="flex items-center justify-between w-full py-3 px-6">
                        <div>Column</div>
                        <div>Column</div>
                        <div>Column</div>
                        <div>Column</div>
                    </div>
                    <div class="flex items-center justify-between w-full py-3 px-6 bg-gray-100">
                        <div>Column</div>
                        <div>Column</div>
                        <div>Column</div>
                        <div>Column</div>
                    </div>
                    <div class="flex items-center justify-between w-full py-3 px-6">
                        <div>Column</div>
                        <div>Column</div>
                        <div>Column</div>
                        <div>Column</div>
                    </div> -->
                </div>

                <div class="flex items-center justify-between bg-gray-100 text-gray-600 text-sm py-3 px-6">
                    <div class="flex-shrink">
                        Showing <span class="font-semibold text-gray-700">1 of 2</span> users
                    </div>

                    <div class="flex items-center font-medium">
                        <pagination :links="users.links"></pagination>
                        <!-- <div class="flex items-center cursor-pointer rounded mx-2px h-6 w-6 leading-none justify-center text-gray-500">
                            <icon name="chevron-left"></icon>
                        </div>
                        <div class="flex items-center cursor-pointer rounded mx-2px h-6 w-6 leading-none justify-center bg-gray-500 text-white">1</div>
                        <div class="flex items-center cursor-pointer rounded mx-2px h-6 w-6 leading-none justify-center hover:bg-gray-300">2</div>
                        <div class="flex items-center cursor-pointer rounded mx-2px h-6 w-6 leading-none justify-center hover:bg-gray-300">3</div>
                        <div class="flex items-center cursor-pointer rounded mx-2px h-6 w-6 leading-none justify-center hover:bg-gray-300">4</div>
                        <div class="flex items-center cursor-pointer rounded mx-2px h-6 w-6 leading-none justify-center hover:bg-gray-300">
                            <icon name="chevron-right"></icon>
                        </div> -->

                        <div class="flex items-center border-l ml-4 pl-4">
                            <p>Go to page</p>

                            <input type="text" class="w-12 rounded border py-1 px-2 mx-2">

                            <button class="button-text">
                                Go
                            </button>
                        </div>
                    </div>
                </div>
            </div>
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
    </admin-layout>
</template>

<script>
import findIndex from 'lodash/findIndex';
import pickBy from 'lodash/pickBy';
import debounce from 'lodash/debounce';
import UserAvatar from '@/Shared/Avatars/UserAvatar';
import ModalHelpers from '@/Utils/Mixins/ModalHelpers';
import SearchFilter from '@/Shared/SearchFilter';
import Pagination from '@/Shared/Pagination';

export default {
    components: { UserAvatar, SearchFilter, Pagination },

    mixins: [ModalHelpers],

    props: {
        filters: {
            type: Object,
            required: true
        },
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
            form: {
                search: this.filters.search
            }
        };
    },

    watch: {
        form: {
            handler: 'refreshUsersList',
            deep: true
        }
    },

    methods: {
        confirmRemove (user, toggle) {
            toggle();
            this.showModal(user);
        },

        refreshUsersList: debounce(function () {
            const query = pickBy(this.form);

            this.$inertia.replace(
                this.route('users.index', Object.keys(query).length ? query : { remember: 'forget' })
            );
        }, 250),

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
