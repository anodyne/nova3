<template>
    <sidebar-layout>
        <page-header title="Themes">
            <template v-if="themes.can.create" #controls>
                <inertia-link :href="route('themes.create')" class="button button-primary">
                    Add Theme
                </inertia-link>
            </template>
        </page-header>

        <panel no-padding>
            <template #header>
                <search-filter
                    v-model="form.search"
                    class="w-1/2"
                    placeholder="Find a theme..."
                    @reset="form.search = ''"
                ></search-filter>

                <button class="button button-small button-soft button-icon">
                    <icon name="filter"></icon>
                </button>
            </template>

            <div class="flex items-center justify-between w-full py-2 px-6 bg-gray-200 border-t border-b text-xs uppercase tracking-wide font-semibold text-gray-600">
                <div class="w-1/3">Theme Name</div>
                <div class="w-1/3">Location</div>
                <div class="flex-auto">Status</div>
            </div>

            <div v-if="themes.data.length === 0" class="flex items-center py-3 px-6 font-semibold border-b text-warning-700">
                <icon name="alert-triangle" class="mr-3 flex-shrink-0 h-6 w-6"></icon>
                <div>No themes found.</div>
            </div>

            <div
                v-for="theme in themes.data"
                :key="theme.id"
                class="flex items-center justify-between w-full py-3 px-6 border-b odd:bg-gray-100"
            >
                <div class="w-1/3">
                    {{ theme.name }}
                </div>

                <div class="w-1/3">
                    themes/{{ theme.location }}
                </div>

                <div class="flex-auto">
                    <div class="badge badge-success">Active</div>
                </div>

                <div class="flex-shrink">
                    <dropdown placement="bottom-end">
                        <icon name="more-horizontal" class="h-6 w-6"></icon>

                        <template #dropdown="{ toggle }">
                            <inertia-link
                                v-if="themes.can.view"
                                :href="route('themes.show', { theme })"
                                class="dropdown-link"
                            >
                                <icon name="eye" class="dropdown-icon"></icon>
                                View
                            </inertia-link>
                            <inertia-link
                                v-if="themes.can.update"
                                :href="route('themes.edit', { theme })"
                                class="dropdown-link"
                            >
                                <icon name="edit" class="dropdown-icon"></icon>
                                Edit
                            </inertia-link>
                            <button
                                v-if="themes.can.delete"
                                class="dropdown-link-danger"
                                @click.prevent="confirmRemove(theme, toggle)"
                            >
                                <icon name="delete" class="dropdown-icon"></icon>
                                Delete
                            </button>
                        </template>
                    </dropdown>
                </div>
            </div>

            <template #footer>
                <div class="flex-shrink">
                    Showing <span class="font-semibold text-gray-700">1 of 2</span> themes
                </div>

                <div class="flex items-center font-medium">
                    <pagination :links="themes.links"></pagination>

                    <div class="flex items-center border-l ml-4 pl-4">
                        <p>Go to page</p>

                        <input type="text" class="w-12 rounded border py-1 px-2 mx-2">

                        <button class="button-text">
                            Go
                        </button>
                    </div>
                </div>
            </template>
        </panel>

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
import pickBy from 'lodash/pickBy';
import debounce from 'lodash/debounce';
import findIndex from 'lodash/findIndex';
import ModalHelpers from '@/Utils/Mixins/ModalHelpers';
import SearchFilter from '@/Shared/SearchFilter';
import Pagination from '@/Shared/Pagination';
import Panel from '@/Shared/Panel';

export default {
    components: { Pagination, SearchFilter, Panel },

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
        confirmRemove (role, toggle) {
            toggle();
            this.showModal(role);
        },

        refreshThemesList: debounce(function () {
            const query = pickBy(this.form);

            this.$inertia.replace(
                this.route('themes.index', Object.keys(query).length ? query : { remember: 'forget' })
            );
        }, 250),

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
