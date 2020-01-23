<template>
    <admin-layout>
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

        <!-- <section>
            <div class="mb-6 w-1/3">
                <search-filter
                    v-model="form.search"
                    placeholder="Find a role..."
                    @reset="form.search = ''"
                ></search-filter>
            </div>

            <div
                v-for="role in roles.data"
                :key="role.id"
                class="panel flex items-center justify-between"
            >
                <div>
                    {{ role.display_name }}
                </div>

                <div>
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

            <pagination :links="roles.links"></pagination>
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
                        v-for="role in roles.data"
                        :key="role.id"
                        class="flex items-center justify-between w-full py-3 px-6 border-b odd:bg-gray-100"
                    >
                        <div>
                            {{ role.display_name }}
                        </div>

                        <div>
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
                        Showing <span class="font-semibold text-gray-700">1 of 2</span> roles
                    </div>

                    <div class="flex items-center font-medium">
                        <pagination :links="roles.links"></pagination>
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
    </admin-layout>
</template>

<script>
import pickBy from 'lodash/pickBy';
import debounce from 'lodash/debounce';
import SearchFilter from '@/Shared/SearchFilter';
import ModalHelpers from '@/Utils/Mixins/ModalHelpers';
import Pagination from '@/Shared/Pagination';

export default {
    components: { Pagination, SearchFilter },

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
        }
    }
};
</script>
