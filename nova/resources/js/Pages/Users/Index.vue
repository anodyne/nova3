<template>
    <sidebar-layout>
        <page-header title="Users">
            <template v-if="can.create" #controls>
                <inertia-link :href="route('users.create')" class="button is-primary">
                    Create User
                </inertia-link>
            </template>
        </page-header>

        <transition-group
            tag="div"
            class="row"
            leave-active-class="animated fadeOut"
        >
            <div
                v-for="(user, index) in filteredUsers"
                :key="user.id"
                class="col-6 mb-6"
            >
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ user.name }}</div>
                    </div>

                    <div class="card-body"></div>

                    <div class="card-footer">
                        <inertia-link
                            v-if="user.can.update"
                            :href="route('users.edit', { user })"
                            class="button is-secondary"
                        >
                            <nova-icon name="edit"></nova-icon>
                        </inertia-link>
                        <a
                            v-if="user.can.delete"
                            role="button"
                            class="button is-danger"
                            @click="remove(user, index)"
                        >
                            <nova-icon name="delete"></nova-icon>
                        </a>
                    </div>
                </div>
            </div>
        </transition-group>
    </sidebar-layout>
</template>

<script>
import From from '@/Utils/Form';
import findIndex from 'lodash/findIndex';

export default {
    props: {
        pendingUsers: {
            type: Object,
            required: true
        },
        users: {
            type: Array,
            required: true
        }
    },

    data () {
        return {
            allUsers: this.themes,
            form: new Form(),
            search: ''
        };
    },

    computed: {
        filteredUsers () {
            return this.allUsers.filter((user) => {
                //
            });
        }
    },

    methods: {
        remove (user) {
            this.form.delete({
                url: this.route('users.destroy', { user }),
                then: (data) => {
                    const index = findIndex(this.allUsers, { id: user.id });

                    this.allUsers.splice(index, 1);

                    this.$toast.message(`${user.name} was successfully deleted.`).success();
                }
            });
        }
    }
};
</script>
