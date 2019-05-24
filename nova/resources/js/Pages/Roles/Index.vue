<template>
    <sidebar-layout>
        <page-header title="Roles">
            <inertia-link
                v-if="roles.can.create"
                slot="controls"
                :href="route('roles.create')"
                class="button is-primary"
            >
                Create Role
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
                        placeholder="Find a role..."
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
                        Role Name
                    </div>
                </div>

                <div
                    v-for="role in filteredRoles"
                    :key="role.id"
                    class="row"
                >
                    <div class="col">
                        {{ role.title }}
                    </div>
                    <div class="col-auto">
                        <nova-icon
                            v-if="role.locked"
                            v-tippy
                            name="lock"
                            class="text-gray-600"
                            title="This role is locked and cannot be duplicated, edited, or deleted."
                        ></nova-icon>

                        <dropdown v-else placement="bottom-end">
                            <nova-icon name="more-vertical"></nova-icon>

                            <template #dropdown="{ dropdownProps }">
                                <inertia-link
                                    v-if="role.can.update"
                                    :href="route('roles.edit', { role })"
                                    class="dropdown-link"
                                >
                                    <nova-icon name="edit" class="dropdown-item-icon"></nova-icon>
                                    Edit
                                </inertia-link>
                                <a
                                    v-if="role.can.create"
                                    role="button"
                                    class="dropdown-link"
                                    @click="duplicate(role)"
                                >
                                    <nova-icon name="copy" class="dropdown-item-icon"></nova-icon>
                                    Duplicate
                                </a>
                                <a
                                    v-if="role.can.delete"
                                    role="button"
                                    class="dropdown-link-danger"
                                    @click="confirmRemove(role, dropdownProps)"
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
            title="Delete role?"
            @close="hideModal"
        >
            Are you sure you want to delete the {{ deletingItem.title }} role?

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

                    Inertia.replace(this.route('roles.edit', { role: data }));
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
