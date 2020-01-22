<template>
    <sidebar-layout>
        <page-header title="Themes">
            <template v-if="themes.can.create" #controls>
                <inertia-link :href="route('themes.create')" class="button is-primary">
                    Add Theme
                </inertia-link>
            </template>
        </page-header>

        <install-themes
            :pending-themes="pendingThemes"
            @theme-installed="installedThemes.push($event)"
        ></install-themes>

        <section>
            <div class="mb-6 w-1/3">
                <div class="flex items-center py-1 px-2 rounded-full bg-white border-2 border-transparent text-gray-500 focus-within:bg-white focus-within:border-gray-400 focus-within:text-gray-600">
                    <icon name="search" class="mr-2"></icon>

                    <input
                        v-model="search"
                        type="text"
                        placeholder="Find a theme..."
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
                    v-for="theme in filteredThemes"
                    :key="theme.id"
                    class="panel flex items-center justify-between"
                >
                    <div class="flex flex-col">
                        <div class="font-semibold">{{ theme.name }}</div>
                        <div class="text-gray-600">themes/{{ theme.location }}</div>
                    </div>

                    <div>
                        <dropdown placement="bottom-end">
                            <icon name="more-horizontal" class="h-6 w-6"></icon>

                            <template #dropdown="{ toggle }">
                                <inertia-link
                                    v-if="themes.can.update"
                                    :href="route('themes.edit', { theme })"
                                    class="dropdown-link"
                                >
                                    <icon name="edit" class="dropdown-icon"></icon>
                                    Edit
                                </inertia-link>
                                <a
                                    v-if="themes.can.delete"
                                    role="button"
                                    class="dropdown-link-danger"
                                    @click="confirmRemove(theme, toggle)"
                                >
                                    <icon name="delete" class="dropdown-icon"></icon>
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
            title="Delete theme?"
            @close="hideModal"
        >
            Are you sure you want to delete the {{ deletingItem.title }} theme?

            <template #footer>
                <button class="button is-secondary" @click="hideModal">
                    Cancel
                </button>

                <button
                    type="button"
                    class="button is-danger-vivid ml-4"
                    @click="remove"
                >
                    Delete Theme
                </button>
            </template>
        </modal>
    </sidebar-layout>
</template>

<script>
import findIndex from 'lodash/findIndex';
import Form from '@/Utils/Form';
import InstallThemes from '@/Pages/Themes/Install';
import ModalHelpers from '@/Utils/Mixins/ModalHelpers';

export default {
    components: { InstallThemes },

    mixins: [ModalHelpers],

    props: {
        pendingThemes: {
            type: [Array, Object],
            required: true
        },
        themes: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            form: new Form(),
            installedThemes: this.themes.data,
            search: ''
        };
    },

    computed: {
        filteredThemes () {
            return this.installedThemes.filter((theme) => {
                const searchRegex = new RegExp(this.search, 'i');

                return searchRegex.test(theme.name) || searchRegex.test(theme.location);
            });
        }
    },

    methods: {
        confirmRemove (role, toggle) {
            toggle();
            this.showModal(role);
        },

        remove () {
            this.form.delete({
                url: this.route('themes.destroy', { theme: this.deletingItem }),
                then: (data) => {
                    const index = findIndex(this.installedThemes, { id: data.id });

                    this.$toast
                        .message(`${this.installedThemes[index].name} theme was removed.`)
                        .success();

                    this.installedThemes.splice(index, 1);
                }
            });
        }
    }
};
</script>
