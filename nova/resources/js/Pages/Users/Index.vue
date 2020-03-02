<template>
    <admin-layout>
        <page-header title="Users">
            <inertia-link
                v-if="users.can.create"
                slot="controls"
                :href="$route('users.create')"
                class="button button-primary"
                data-cy="create"
            >
                Add User
            </inertia-link>
        </page-header>

        <panel>
            <div class="bg-white px-4 py-5 | sm:px-6">
                <div>
                    <label for="email" class="sr-only">Find a user</label>
                    <search-filter
                        v-model="form.search"
                        class="w-1/2"
                        placeholder="Find a user..."
                        @reset="form.search = ''"
                    ></search-filter>
                </div>
            </div>

            <ul>
                <li
                    v-for="user in users.data"
                    :key="user.id"
                    class="border-t border-gray-200"
                >
                    <div class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="min-w-0 flex-1 flex items-center">
                                <div class="flex-shrink-0">
                                    <avatar :image-url="user.avatar_url"></avatar>
                                </div>
                                <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                    <div>
                                        <div class="leading-normal font-medium truncate">
                                            {{ user.name }}
                                        </div>
                                        <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                            <icon name="mail" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"></icon>
                                            <span class="truncate">{{ user.email }}</span>
                                        </div>
                                    </div>
                                    <div class="hidden md:block">
                                        <div>
                                            <div class="flex items-center text-sm leading-5 text-gray-500">
                                                <icon name="activity" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"></icon>
                                                Last activity&nbsp;
                                                <time datetime="2020-01-07">January 7, 2020</time>
                                            </div>
                                            <div v-if="user.lastLogin != null" class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                                <icon name="log-in" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"></icon>
                                                Last signed in&nbsp;
                                                <time :datetime="user.lastLoginSimple">{{ user.lastLogin }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500">
                                    <icon name="more-horizontal" class="h-6 w-6"></icon>

                                    <template #dropdown="{ toggle, styles }">
                                        <inertia-link
                                            v-if="user.can.view"
                                            :href="$route('users.show', { user })"
                                            :class="styles.link"
                                            data-cy="view"
                                        >
                                            <icon name="eye" :class="styles.icon"></icon>
                                            View
                                        </inertia-link>
                                        <inertia-link
                                            v-if="user.can.update"
                                            :href="$route('users.edit', { user })"
                                            :class="styles.link"
                                            data-cy="edit"
                                        >
                                            <icon name="edit" :class="styles.icon"></icon>
                                            Edit
                                        </inertia-link>
                                        <template v-if="user.can.delete">
                                            <div :class="styles.divider"></div>
                                            <button
                                                :class="styles.dangerLink"
                                                data-cy="delete"
                                                @click="confirmRemove(user, toggle)"
                                            >
                                                <icon name="trash" :class="styles.dangerIcon"></icon>
                                                Delete
                                            </button>
                                        </template>
                                    </template>
                                </dropdown>
                            </div>
                        </div>
                    </div>
                </li>
                <li v-if="users.meta.total === 0" class="border-t border-warning-100">
                    <div class="block focus:outline-none focus:bg-gray-50">
                        <div class="flex items-center px-4 py-4 bg-warning-50 | sm:px-6">
                            <icon name="alert-triangle" class="h-6 w-6 flex-shrink-0 mr-3 text-warning-400"></icon>
                            <span class="font-medium text-warning-600">No users found</span>
                        </div>
                    </div>
                </li>
            </ul>

            <div v-if="users.meta.total > 0" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 | sm:px-6">
                <pagination
                    :links="users.links"
                    :meta="users.meta"
                    resource-label="user"
                ></pagination>
            </div>
        </panel>

        <modal
            :open="modalIsShown"
            title="Delete Account"
            @close="hideModal"
        >
            Are you sure you want to delete <strong>{{ deletingItem.name }}</strong>'s account?

            <template #footer>
                <button
                    type="button"
                    class="button button-danger | sm:ml-3"
                    data-cy="delete-user"
                    @click="remove"
                >
                    Delete User
                </button>

                <button
                    type="button"
                    class="button mt-3 | sm:mt-0"
                    @click="hideModal"
                >
                    Cancel
                </button>
            </template>
        </modal>
    </admin-layout>
</template>

<script>
import pickBy from 'lodash/pickBy';
import debounce from 'lodash/debounce';
import Avatar from '@/Shared/Avatar';
import ModalHelpers from '@/Utils/Mixins/ModalHelpers';
import SearchFilter from '@/Shared/SearchFilter';
import Pagination from '@/Shared/Pagination';

export default {
    components: {
        Avatar, SearchFilter, Pagination
    },

    mixins: [ModalHelpers],

    props: {
        filters: {
            type: Object,
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
                this.$route('users.index', Object.keys(query).length ? query : { remember: 'forget' })
            );
        }, 250),

        remove () {
            this.$inertia.delete(
                this.$route('users.destroy', { user: this.deletingItem })
            );
        }
    }
};
</script>
