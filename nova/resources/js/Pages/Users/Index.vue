<template>
    <sidebar-layout>
        <page-header title="Users">
            <inertia-link
                v-if="users.can.create"
                slot="controls"
                :href="$route('users.create')"
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
            </template>

            <div class="flex items-center justify-between w-full py-2 px-8 bg-gray-100 border-t border-b text-xs uppercase tracking-wide font-medium text-gray-600">
                <div class="w-1/3">Nickname</div>
                <div class="flex-auto">Email</div>
            </div>

            <div v-if="users.data.length === 0" class="flex items-center py-4 px-8 font-semibold border-b text-warning-700">
                <icon name="alert-triangle" class="mr-3 flex-shrink-0 h-6 w-6"></icon>
                <div>No users found.</div>
            </div>

            <div
                v-for="user in users.data"
                :key="user.id"
                class="flex items-center justify-between w-full py-2 px-8 border-b"
            >
                <div class="flex items-center w-1/3">
                    <avatar size="sm" :image-url="user.avatar_url"></avatar>
                    <div class="ml-3 font-medium">
                        {{ user.nickname }}
                    </div>
                </div>

                <div class="flex-auto">
                    {{ user.email }}
                </div>

                <div class="flex-shrink">
                    <dropdown placement="bottom-end">
                        <icon name="more-horizontal" class="h-6 w-6"></icon>

                        <template #dropdown="{ toggle }">
                            <inertia-link
                                v-if="user.can.update"
                                :href="$route('users.edit', { user })"
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
                <pagination
                    :links="users.links"
                    :meta="users.meta"
                    resource-label="user"
                ></pagination>
            </template>
        </panel>

        <modal
            :open="modalIsShown"
            title="Delete Account"
            @close="hideModal"
        >
            Are you sure you want to delete <strong>{{ deletingItem.nickname }}</strong>'s account?

            <template #footer>
                <button
                    type="button"
                    class="button"
                    @click="hideModal"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    class="button button-danger ml-4"
                    @click="remove"
                >
                    Delete User
                </button>
            </template>
        </modal>
    </sidebar-layout>
</template>

<script>
import pickBy from 'lodash/pickBy';
import debounce from 'lodash/debounce';
import Avatar from '@/Shared/Avatars/Avatar';
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
