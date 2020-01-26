<template>
    <sidebar-layout>
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

        <panel no-padding>
            <template #header>
                <search-filter
                    v-model="form.search"
                    class="w-1/2"
                    placeholder="Find a user..."
                    @reset="form.search = ''"
                ></search-filter>

                <button class="button button-small button-soft button-icon">
                    <icon name="filter"></icon>
                </button>
            </template>

            <div class="flex items-center justify-between w-full py-2 px-6 bg-gray-200 border-t border-b text-xs uppercase tracking-wide font-semibold text-gray-600">
                <div class="w-1/3">Name</div>
                <div class="w-1/3">Email</div>
                <div class="w-1/3"></div>
            </div>

            <div v-if="users.data.length === 0" class="flex items-center py-3 px-6 font-semibold border-b text-warning-700">
                <icon name="alert-triangle" class="mr-3 flex-shrink-0 h-6 w-6"></icon>
                <div>No users found.</div>
            </div>

            <div
                v-for="user in users.data"
                :key="user.id"
                class="flex items-center justify-between w-full py-3 px-6 border-b odd:bg-gray-100"
            >
                <div class="flex items-center w-1/3">
                    <avatar size="sm" :image-url="`https://api.adorable.io/avatars/285/${user.email}`"></avatar>
                    <div class="ml-3 font-medium">
                        {{ user.name }}
                    </div>
                </div>

                <div class="w-1/3">
                    {{ user.email }}
                </div>

                <div class="flex-shrink">
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

            <template #footer>
                <div class="flex-shrink">
                    Showing <span class="font-semibold text-gray-700">1 of 2</span> users
                </div>

                <div class="flex items-center font-medium">
                    <pagination :links="users.links"></pagination>

                    <div class="flex items-center border-l ml-4 pl-4">
                        <p>Go to page</p>

                        <input type="text" class="w-12 rounded border py-1 px-2 mx-2">

                        <button class="button-text">
                            Go
                        </button>
                    </div>
                </div>
            </template>
        </panel>

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
import pickBy from 'lodash/pickBy';
import debounce from 'lodash/debounce';
import Avatar from '@/Shared/Avatars/Avatar';
import ModalHelpers from '@/Utils/Mixins/ModalHelpers';
import SearchFilter from '@/Shared/SearchFilter';
import Pagination from '@/Shared/Pagination';
import Panel from '@/Shared/Panel';

export default {
    components: {
        Avatar, SearchFilter, Pagination, Panel
    },

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
