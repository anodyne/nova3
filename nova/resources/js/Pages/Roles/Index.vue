<template>
    <admin-layout>
        <page-header title="Roles">
            <inertia-link
                v-if="roles.can.create"
                slot="controls"
                :href="$route('roles.create')"
                class="button button-primary"
                data-cy="create"
            >
                Add Role
            </inertia-link>
        </page-header>

        <panel>
            <div class="bg-white px-4 py-5 | sm:px-6">
                <div>
                    <label for="email" class="sr-only">Find a role</label>
                    <search-filter
                        v-model="form.search"
                        class="w-1/2"
                        placeholder="Find a role..."
                        @reset="form.search = ''"
                    ></search-filter>
                </div>
            </div>

            <ul>
                <li
                    v-for="role in roles.data"
                    :key="role.id"
                    class="border-t border-gray-200"
                >
                    <div class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="px-4 py-4 flex items-center sm:px-6">
                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <div class="leading-normal font-medium truncate">
                                        {{ role.display_name }}
                                    </div>
                                    <div class="mt-2 flex">
                                        <div class="flex items-center text-sm leading-5 text-gray-500">
                                            <icon name="users" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"></icon>
                                            <span>
                                                {{ role.usersCount }} assigned {{ userLabel(role.users) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 flex-shrink-0 sm:mt-0">
                                    <avatar-group size="xs" :items="roleUsers(role)"></avatar-group>
                                </div>
                            </div>
                            <div class="ml-5 flex-shrink-0">
                                <dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500">
                                    <icon name="more-horizontal" class="h-6 w-6"></icon>

                                    <template #dropdown="{ toggle, styles }">
                                        <inertia-link
                                            v-if="role.can.view"
                                            :href="$route('roles.show', { role })"
                                            :class="styles.link"
                                            data-cy="view"
                                        >
                                            <icon name="eye" :class="styles.icon"></icon>
                                            View
                                        </inertia-link>
                                        <inertia-link
                                            v-if="role.can.update"
                                            :href="$route('roles.edit', { role })"
                                            :class="styles.link"
                                            data-cy="edit"
                                        >
                                            <icon name="edit" :class="styles.icon"></icon>
                                            Edit
                                        </inertia-link>
                                        <button
                                            v-if="role.can.duplicate"
                                            :class="styles.link"
                                            data-cy="duplicate"
                                            @click.prevent="duplicate(role)"
                                        >
                                            <icon name="copy" :class="styles.icon"></icon>
                                            Duplicate
                                        </button>
                                        <template v-if="role.can.delete">
                                            <div :class="styles.divider"></div>
                                            <button
                                                :class="styles.dangerLink"
                                                data-cy="delete"
                                                @click.prevent="confirmRemove(role, toggle)"
                                            >
                                                <icon name="trash" :class="styles.dangerIcon"></icon>
                                                Delete
                                            </button>
                                        </template>
                                        <div v-if="role.locked">
                                            <div :class="styles.divider"></div>
                                            <div :class="styles.text">
                                                This role is locked and cannot be duplicated or deleted.
                                            </div>
                                        </div>
                                    </template>
                                </dropdown>
                            </div>
                        </div>
                    </div>
                </li>
                <li v-if="roles.meta.total === 0" class="border-t border-warning-100">
                    <div class="block focus:outline-none focus:bg-gray-50">
                        <div class="flex items-center px-4 py-4 bg-warning-50 | sm:px-6">
                            <icon name="alert-triangle" class="h-6 w-6 flex-shrink-0 mr-3 text-warning-400"></icon>
                            <span class="font-medium text-warning-600">No roles found</span>
                        </div>
                    </div>
                </li>
            </ul>

            <div v-if="roles.meta.total > 0" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 | sm:px-6">
                <pagination
                    :links="roles.links"
                    :meta="roles.meta"
                    resource-label="role"
                ></pagination>
            </div>
        </panel>

        <modal
            :open="modalIsShown"
            title="Delete Role"
            @close="hideModal"
        >
            Are you sure you want to delete the <strong>{{ deletingItem.display_name }}</strong> role? This change is permanent and cannot be undone. Any users who have been assigned the role will have all permissions defined by this role removed from their personal permissions.

            <template #footer>
                <button
                    type="button"
                    class="button button-danger | sm:ml-3"
                    data-cy="delete-role"
                    @click="remove"
                >
                    Delete Role
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
import SearchFilter from '@/Shared/SearchFilter';
import ModalHelpers from '@/Utils/Mixins/ModalHelpers';
import Pagination from '@/Shared/Pagination';
import AvatarGroup from '@/Shared/AvatarGroup';
import pluralize from 'pluralize';

export default {
    components: {
        Pagination, SearchFilter, AvatarGroup
    },

    mixins: [ModalHelpers],

    props: {
        filters: {
            type: Object,
            required: true
        },
        roles: {
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
            handler: 'refreshRolesList',
            deep: true
        }
    },

    methods: {
        confirmRemove (role, toggle) {
            toggle();
            this.showModal(role);
        },

        duplicate (role) {
            this.$inertia.post(
                this.$route('roles.duplicate', { originalRole: role })
            );
        },

        refreshRolesList: debounce(function () {
            const query = pickBy(this.form);

            this.$inertia.replace(
                this.$route('roles.index', Object.keys(query).length ? query : { remember: 'forget' })
            );
        }, 250),

        remove () {
            this.$inertia.delete(
                this.$route('roles.destroy', { role: this.deletingItem })
            );
        },

        roleUsers (role) {
            return role.users.map(user => ({
                'image-url': user.avatar_url,
                tooltip: user.name
            }));
        },

        userLabel (users) {
            return pluralize('user', users.length);
        }
    }
};
</script>
