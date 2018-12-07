<template>
    <div
        v-on-clickaway="away"
        class="item-picker"
    >
        <div class="item-picker-selector">
            <div
                v-if="selectedUser"
                role="button"
                class="item-picker-toggle"
                @click.prevent="show = !show"
            >
                <div class="item-picker-selected">
                    <avatar
                        :item="selectedUser"
                        :show-metadata="false"
                        :show-status="false"
                        size="sm"
                        type="image"
                    />
                    <div
                        class="ml-3"
                        v-html="showIcon('more')"
                    />
                </div>
                <input
                    :name="fieldName"
                    v-model="selectedUser.id"
                    type="hidden"
                >
            </div>
            <div
                v-if="!selectedUser"
                role="button"
                class="item-picker-toggle"
                @click.prevent="show = !show"
            >
                <div class="item-picker-selected">
                    <span v-text="lang('users-none')"/>
                    <span
                        class="ml-3"
                        v-html="showIcon('more')"
                    />
                </div>
            </div>

            <slot/>
        </div>

        <div
            v-show="show"
            class="items-menu"
        >
            <div class="search-group">
                <span class="search-field">
                    <div v-html="showIcon('search')"/>
                    <input
                        :placeholder="lang('users-find')"
                        v-model="search"
                        type="text"
                    >
                </span>
                <a
                    href="#"
                    class="clear-search ml-2"
                    @click.prevent="search = ''"
                    v-html="showIcon('close-alt')"
                />
            </div>

            <div
                v-show="filteredUsers.length == 0"
                class="items-menu-alert"
            >
                <div
                    class="alert alert-warning"
                    v-text="lang('users-error-not-found')"
                />
            </div>

            <div
                v-if="selectedUser != false"
                class="items-menu-item"
                @click.prevent="selectUser(false)"
                v-text="lang('users-none')"
            />

            <div
                v-for="user in filteredUsers"
                :key="user.id"
                class="items-menu-item"
                @click.prevent="selectUser(user)"
            >
                <avatar
                    :item="user"
                    :show-metadata="false"
                    :show-status="false"
                    size="sm"
                    type="image"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { mixin as clickaway } from 'vue-clickaway';
import Avatar from './Avatar.vue';

export default {

    components: { Avatar },

    mixins: [clickaway],
    props: {
        fieldName: {
            type: String,
            default: 'user_id'
        },
        items: {
            type: Array,
            default: () => { return []; }
        },
        selected: {
            type: Object,
            default: () => { return {}; }
        }
    },

    data () {
        return {
            users: [],
            search: '',
            selectedUser: false,
            show: false
        };
    },

    computed: {
        filteredUsers () {
            const self = this;

            return this.users.filter((user) => {
                const searchRegex = new RegExp(self.search, 'i');

                return searchRegex.test(user.name) || searchRegex.test(user.email);
            });
        }
    },

    created () {
        const self = this;

        if (this.selected) {
            this.selectedUser = this.selected;
        }

        this.fetch();

        this.$events.$on('user-picker-refresh', () => {
            self.fetch();
        });

        this.$events.$on('user-picker-reset', () => {
            self.selectedUser = false;
        });
    },

    methods: {
        away () {
            this.show = false;
        },

        fetch () {
            const self = this;

            if (this.items) {
                this.users = this.items;
            } else {
                Nova.request({
                    url: route('api.users'),
                    method: 'get'
                }).then((response) => {
                    self.users = response.data;
                });
            }
        },

        lang (key, attributes = '') {
            return window.lang(key, attributes);
        },

        selectUser (user) {
            this.selectedUser = user;
            this.show = false;
            this.search = '';

            this.$events.$emit('user-picker-selected', this.selectedUser);
        },

        showIcon (icon) {
            return window.icon(icon);
        }
    }
};
</script>
