<template>
    <sidebar-layout>
        <page-header title="Roles">
            <inertia-link
                v-if="roles.can.create"
                slot="controls"
                :href="route('roles.create')"
                class="button button-primary"
            >
                Add Role
            </inertia-link>
        </page-header>

        <panel no-padding>
            <template #header>
                <search-filter
                    v-model="form.search"
                    class="w-1/2"
                    placeholder="Find a role..."
                    @reset="form.search = ''"
                ></search-filter>

                <button class="button button-small button-soft button-icon">
                    <icon name="filter"></icon>
                </button>
            </template>

            <div class="flex items-center justify-between w-full py-2 px-6 bg-gray-200 border-t border-b text-xs uppercase tracking-wide font-semibold text-gray-600">
                <div class="w-1/2">Role Name</div>
                <div class="flex-auto">Assigned Users</div>
            </div>

            <div v-if="roles.data.length === 0" class="flex items-center py-3 px-6 font-semibold border-b text-warning-700">
                <icon name="alert-triangle" class="mr-3 flex-shrink-0 h-6 w-6"></icon>
                <div>No roles found.</div>
            </div>

            <div
                v-for="role in roles.data"
                :key="role.id"
                class="flex items-center justify-between w-full py-3 px-6 border-b odd:bg-gray-100"
            >
                <div class="w-1/2">
                    {{ role.display_name }}
                </div>

                <div class="flex-auto">
                    <avatar-group size="xs" :items="roleUsers(role)"></avatar-group>
                </div>

                <div class="flex-shrink">
                    <dropdown placement="bottom-end">
                        <icon name="more-horizontal" class="h-6 w-6"></icon>

                        <template #dropdown="{ toggle }">
                            <inertia-link
                                v-if="role.can.view"
                                :href="route('roles.show', { role })"
                                class="dropdown-link"
                            >
                                <icon name="eye" class="dropdown-icon"></icon>
                                View
                            </inertia-link>
                            <inertia-link
                                v-if="role.can.update"
                                :href="route('roles.edit', { role })"
                                class="dropdown-link"
                            >
                                <icon name="edit" class="dropdown-icon"></icon>
                                Edit
                            </inertia-link>
                            <button
                                v-if="role.can.create && role.can.update"
                                class="dropdown-link"
                                @click.prevent="duplicate(role)"
                            >
                                <icon name="copy" class="dropdown-icon"></icon>
                                Duplicate
                            </button>
                            <button
                                v-if="role.can.delete"
                                class="dropdown-link-danger"
                                @click.prevent="confirmRemove(role, toggle)"
                            >
                                <icon name="delete" class="dropdown-icon"></icon>
                                Delete
                            </button>
                            <div v-if="role.locked">
                                <div class="dropdown-divider"></div>
                                <div class="dropdown-text italic">
                                    This role is locked and cannot be duplicated, edited, or deleted.
                                </div>
                            </div>
                        </template>
                    </dropdown>
                </div>
            </div>

            <template #footer>
                <div class="flex-shrink">
                    Showing <span class="font-semibold text-gray-700">1 of 2</span> roles
                </div>

                <div class="flex items-center font-medium">
                    <pagination :links="roles.links"></pagination>

                    <div class="flex items-center border-l ml-4 pl-4">
                        <p>Go to page</p>

                        <input type="text" class="w-12 rounded border py-1 px-2 mx-2">

                        <button class="button button-text">
                            Go
                        </button>
                    </div>
                </div>
            </template>
        </panel>

        <modal
            :open="modalIsShown"
            title="Delete Role"
            @close="hideModal"
        >
            Are you sure you want to delete the <strong>{{ deletingItem.display_name }}</strong> role? This change is permanent and cannot be undone. Any users who have been assigned the role will have all permissions defined by this role removed from their personal permissions.

            <template #footer>
                <button class="button" @click="hideModal">
                    Cancel
                </button>

                <button
                    type="button"
                    class="button button-danger ml-4"
                    @click="remove"
                >
                    Delete Role
                </button>
            </template>
        </modal>
    </sidebar-layout>
</template>

<script>
import pickBy from 'lodash/pickBy';
import debounce from 'lodash/debounce';
import SearchFilter from '@/Shared/SearchFilter';
import ModalHelpers from '@/Utils/Mixins/ModalHelpers';
import Pagination from '@/Shared/Pagination';
import AvatarGroup from '@/Shared/Avatars/AvatarGroup';
import Panel from '@/Shared/Panel';

export default {
    components: {
        Pagination, SearchFilter, AvatarGroup, Panel
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
                this.route('roles.duplicate', { originalRole: role })
            );
        },

        refreshRolesList: debounce(function () {
            const query = pickBy(this.form);

            this.$inertia.replace(
                this.route('roles.index', Object.keys(query).length ? query : { remember: 'forget' })
            );
        }, 250),

        remove () {
            this.$inertia.delete(
                this.route('roles.destroy', { role: this.deletingItem })
            );
        },

        roleUsers (role) {
            return role.users.map(user => ({
                'image-url': `https://api.adorable.io/avatars/285/${user.email}`,
                tooltip: user.name
            }));
        }
    }
};
</script>
