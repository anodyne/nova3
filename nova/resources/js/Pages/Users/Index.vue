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

        <section>
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
