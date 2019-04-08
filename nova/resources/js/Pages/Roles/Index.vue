<template>
    <sidebar-layout>
        <page-header title="Roles">
            <inertia-link
                v-if="can.create"
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
                        <dropdown placement="bottom-end">
                            <nova-icon name="more-vertical"></nova-icon>

                            <template #dropdown>
                                <inertia-link
                                    v-if="can.update"
                                    :href="route('roles.edit', { role })"
                                    class="dropdown-link"
                                >
                                    <nova-icon name="edit" class="dropdown-item-icon"></nova-icon>
                                    Edit
                                </inertia-link>
                                <a
                                    v-if="can.delete"
                                    role="button"
                                    class="dropdown-link-danger"
                                    @click="remove(role)"
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
    </sidebar-layout>
</template>

<script>
import axios from '@/Utils/axios';
import findIndex from 'lodash/findIndex';

export default {
    props: {
        can: {
            type: Object,
            required: true
        },
        roles: {
            type: Array,
            required: true
        }
    },

    data () {
        return {
            availableRoles: this.roles,
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
        remove (role) {
            axios.delete(route('roles.destroy', { role }))
                .then(({ data }) => {
                    const index = findIndex(this.availableRoles, { id: data.id });

                    this.availableRoles.splice(index, 1);

                    // this.$toast.message('Role was successfully deleted.').success().make();
                })
                .catch(({ error }) => {
                    //
                });
        }
    }
};
</script>
