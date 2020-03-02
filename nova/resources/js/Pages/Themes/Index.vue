<template>
    <admin-layout>
        <page-header title="Themes">
            <template v-if="themes.can.create" #controls>
                <inertia-link :href="$route('themes.create')" class="button button-primary">
                    Add Theme
                </inertia-link>
            </template>
        </page-header>

        <panel>
            <div class="bg-white px-4 py-5 | sm:px-6">
                <div>
                    <label for="email" class="sr-only">Find a theme</label>
                    <search-filter
                        v-model="form.search"
                        class="w-1/2"
                        placeholder="Find a theme..."
                        @reset="form.search = ''"
                    ></search-filter>
                </div>
            </div>

            <ul>
                <li
                    v-for="theme in themes.data"
                    :key="theme.id"
                    class="border-t border-gray-200"
                >
                    <div class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="px-4 py-4 flex items-center sm:px-6">
                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <div class="leading-normal font-medium truncate">
                                        {{ theme.name }}
                                    </div>
                                    <div class="mt-2 flex">
                                        <div class="flex items-center text-sm leading-5 text-gray-500">
                                            <icon name="folder" class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"></icon>
                                            <span>
                                                themes/{{ theme.location }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ml-5 flex-shrink-0">
                                <dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500">
                                    <icon name="more-horizontal" class="h-6 w-6"></icon>

                                    <template #dropdown="{ toggle, styles }">
                                        <inertia-link
                                            v-if="themes.can.view"
                                            :href="$route('themes.show', { theme })"
                                            :class="styles.link"
                                        >
                                            <icon name="eye" :class="styles.icon"></icon>
                                            View
                                        </inertia-link>
                                        <inertia-link
                                            v-if="themes.can.update"
                                            :href="$route('themes.edit', { theme })"
                                            :class="styles.link"
                                        >
                                            <icon name="edit" :class="styles.icon"></icon>
                                            Edit
                                        </inertia-link>
                                        <template v-if="themes.can.delete">
                                            <div :class="styles.divider"></div>
                                            <button
                                                :class="styles.dangerLink"
                                                @click.prevent="confirmRemove(theme, toggle)"
                                            >
                                                <icon name="trash" :class="styles.dangerIcon"></icon>
                                                Delete
                                            </button>
                                        </template>
                                    </template>
                                </dropdown>
                            </div>
                        </div>
                    </div>
                </li>
                <li v-if="themes.meta.total === 0" class="border-t border-warning-100">
                    <div class="block focus:outline-none focus:bg-gray-50">
                        <div class="flex items-center px-4 py-4 bg-warning-50 | sm:px-6">
                            <icon name="alert-triangle" class="h-6 w-6 flex-shrink-0 mr-3 text-warning-400"></icon>
                            <span class="font-medium text-warning-600">No themes found</span>
                        </div>
                    </div>
                </li>
            </ul>

            <div v-if="themes.meta.total > 0" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 | sm:px-6">
                <pagination
                    :links="themes.links"
                    :meta="themes.meta"
                    resource-label="theme"
                ></pagination>
            </div>
        </panel>

        <modal
            :open="modalIsShown"
            title="Delete theme?"
            @close="hideModal"
        >
            Are you sure you want to delete the {{ deletingItem.title }} theme?

            <template #footer>
                <button
                    type="button"
                    class="button button-danger | sm:ml-3"
                    data-cy="delete-theme"
                    @click="remove"
                >
                    Delete Theme
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
import findIndex from 'lodash/findIndex';
import ModalHelpers from '@/Utils/Mixins/ModalHelpers';
import SearchFilter from '@/Shared/SearchFilter';
import Pagination from '@/Shared/Pagination';

export default {
    components: { Pagination, SearchFilter },

    mixins: [ModalHelpers],

    props: {
        filters: {
            type: Object,
            required: true
        },
        themes: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            form: {
                search: this.filters.search
            },
            installedThemes: this.themes.data
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

    watch: {
        form: {
            handler: 'refreshThemesList',
            deep: true
        }
    },

    methods: {
        confirmRemove (theme, toggle) {
            toggle();
            this.showModal(theme);
        },

        refreshThemesList: debounce(function () {
            const query = pickBy(this.form);

            this.$inertia.replace(
                this.$route('themes.index', Object.keys(query).length ? query : { remember: 'forget' })
            );
        }, 250),

        remove () {
            this.$inertia.delete(
                this.$route('themes.destroy', { theme: this.deletingItem })
            );
        }
    }
};
</script>
