<template>
    <sidebar-layout>
        <page-header title="Roles">
            <inertia-link
                v-if="roles.can.create"
                slot="controls"
                :href="route('roles.create')"
                class="button is-primary"
            >
                Add Role
            </inertia-link>
        </page-header>

        <section>
            <div class="mb-6 w-1/3">
                <div class="flex items-center py-1 px-2 rounded-full bg-white border-2 border-transparent text-gray-500 focus-within:bg-white focus-within:border-gray-400 focus-within:text-gray-600">
                    <icon name="search" class="mr-2"></icon>

                    <input
                        v-model="search"
                        type="text"
                        placeholder="Find a role..."
                        class="w-full appearance-none bg-transparent text-gray-800 focus:outline-none"
                    >

                    <a
                        v-show="search != ''"
                        role="button"
                        class="ml-2 text-gray-500 hover:text-danger-500"
                        @click="search = ''"
                    >
                        <icon name="close"></icon>
                    </a>
                </div>
            </div>

            <transition-group leave-active-class="animated fadeOut">
                <div
                    v-for="role in filteredRoles"
                    :key="role.id"
                    class="panel flex items-center"
                >
                    <div class="flex-1">
                        {{ role.title }}
                    </div>
                    <div class="flex-shrink">
                        <icon
                            v-if="role.locked"
                            v-tippy
                            name="lock"
                            class="text-gray-600"
                            title="This role is locked and cannot be duplicated, edited, or deleted."
                        ></icon>

                        <dropdown v-else placement="bottom-end">
                            <icon name="more-horizontal"></icon>

                            <template #dropdown="{ dropdownProps }">
                                <inertia-link
                                    v-if="role.can.update"
                                    :href="route('roles.edit', { role })"
                                    class="dropdown-link"
                                >
                                    <icon name="edit" class="dropdown-item-icon"></icon>
                                    Edit
                                </inertia-link>
                                <a
                                    v-if="role.can.create"
                                    role="button"
                                    class="dropdown-link"
                                    @click="duplicate(role)"
                                >
                                    <icon name="copy" class="dropdown-item-icon"></icon>
                                    Duplicate
                                </a>
                                <a
                                    v-if="role.can.delete"
                                    role="button"
                                    class="dropdown-link-danger"
                                    @click="confirmRemove(role, dropdownProps)"
                                >
                                    <icon name="delete" class="dropdown-item-icon"></icon>
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
            title="Delete Role"
            @close="hideModal"
        >
            Are you sure you want to delete the <strong>{{ deletingItem.title }}</strong> role? This change is permanent and cannot be undone. Any users with this role will have any abilities defined by this role removed from their permissions.

            <template #footer>
                <button class="button is-secondary" @click="hideModal">
                    Cancel
                </button>

                <button
                    type="button"
                    class="button is-danger-vivid ml-4"
                    @click="remove"
                >
                    Delete Role
                </button>
            </template>
        </modal>
    </sidebar-layout>
</template>

<script>
import findIndex from 'lodash/findIndex';
import Form from '@/Utils/Form';
import ModalHelpers from '@/Utils/Mixins/ModalHelpers';

export default {
    mixins: [ModalHelpers],

    props: {
        roles: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            availableRoles: this.roles.data,
            form: new Form(),
            search: ''
        };
    },

    computed: {
        filteredRoles () {
            return this.availableRoles.filter((role) => {
                const searchRegex = new RegExp(this.search, 'i');

                return searchRegex.test(role.name) || searchRegex.test(role.title);
            });
        }
    },

    methods: {
        confirmRemove (role, { toggle }) {
            toggle();
            this.showModal(role);
        },

        duplicate (role) {
            this.form.post({
                url: this.route('roles.duplicate', { originalRole: role }),
                then: (data) => {
                    this.$toast.message(`${role.title} role was duplicated.`).success();

                    this.availableRoles.push(data);

                    this.$inertia.replace(this.route('roles.edit', { role: data }));
                }
            });
        },

        remove () {
            this.form.delete({
                url: this.route('roles.destroy', { role: this.deletingItem }),
                then: (data) => {
                    const index = findIndex(this.availableRoles, { id: data.id });

                    this.$toast
                        .message(`${data.title} role was removed.`)
                        .success();

                    this.availableRoles.splice(index, 1);
                }
            });
        }
    }
};
</script>
