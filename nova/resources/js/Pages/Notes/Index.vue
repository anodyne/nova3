<template>
    <admin-layout>
        <page-header title="Notes">
            <inertia-link
                v-if="!hasEmptyState"
                slot="controls"
                :href="$route('notes.create')"
                class="button button-primary"
                data-cy="create"
            >
                Add Note
            </inertia-link>
        </page-header>

        <empty-state
            v-if="hasEmptyState"
            image="notes"
            link-label="Add a note now"
            :link-url="$route('notes.create')"
            message="Notes are a great way to keep your thoughts organized, be it about things you need to do for the game, a story idea, or as a scratchpad for your next great story entry."
        ></empty-state>

        <panel v-else>
            <div class="bg-white px-4 py-5 | sm:px-6">
                <div>
                    <label for="email" class="sr-only">Find a note</label>
                    <search-filter
                        v-model="form.search"
                        class="w-1/2"
                        placeholder="Find a note..."
                        @reset="form.search = ''"
                    ></search-filter>
                </div>
            </div>

            <ul>
                <li
                    v-for="note in notes.data"
                    :key="note.id"
                    class="border-t border-gray-200"
                >
                    <div class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                        <div class="px-4 py-4 flex items-center sm:px-6">
                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <div class="leading-normal font-medium truncate">
                                        {{ note.title }}
                                    </div>
                                </div>
                            </div>
                            <div class="ml-5 flex-shrink-0">
                                <dropdown placement="bottom-end" class="text-gray-400 hover:text-gray-500">
                                    <icon name="more-horizontal" class="h-6 w-6"></icon>

                                    <template #dropdown="{ toggle, styles }">
                                        <inertia-link
                                            :href="$route('notes.show', { note })"
                                            :class="styles.link"
                                        >
                                            <icon name="eye" :class="styles.icon"></icon>
                                            View
                                        </inertia-link>
                                        <inertia-link
                                            :href="$route('notes.edit', { note })"
                                            :class="styles.link"
                                        >
                                            <icon name="edit" :class="styles.icon"></icon>
                                            Edit
                                        </inertia-link>
                                        <button
                                            :class="styles.link"
                                            @click.prevent="duplicate(note)"
                                        >
                                            <icon name="copy" :class="styles.icon"></icon>
                                            Duplicate
                                        </button>
                                        <div :class="styles.divider"></div>
                                        <button
                                            :class="styles.dangerLink"
                                            @click.prevent="confirmRemove(note, toggle)"
                                        >
                                            <icon name="trash" :class="styles.dangerIcon"></icon>
                                            Delete
                                        </button>
                                    </template>
                                </dropdown>
                            </div>
                        </div>
                    </div>
                </li>
                <li v-if="notes.meta.total === 0" class="border-t border-warning-100">
                    <div class="block focus:outline-none focus:bg-gray-50">
                        <div class="flex items-center px-4 py-4 bg-warning-50 | sm:px-6">
                            <icon name="alert-triangle" class="h-6 w-6 flex-shrink-0 mr-3 text-warning-400"></icon>
                            <span class="font-medium text-warning-600">No notes found</span>
                        </div>
                    </div>
                </li>
            </ul>

            <div v-if="notes.meta.total > 0" class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 | sm:px-6">
                <pagination
                    :links="notes.links"
                    :meta="notes.meta"
                    resource-label="role"
                ></pagination>
            </div>
        </panel>

        <modal
            :open="modalIsShown"
            title="Delete Note"
            @close="hideModal"
        >
            Are you sure you want to delete the <strong>{{ deletingItem.title }}</strong> note? This change is permanent and cannot be undone.

            <template #footer>
                <button
                    type="button"
                    class="button button-danger | sm:ml-3"
                    data-cy="delete-note"
                    @click="remove"
                >
                    Delete Note
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
import SearchFilter from '@/Shared/SearchFilter';
import ModalHelpers from '@/Utils/Mixins/ModalHelpers';
import Pagination from '@/Shared/Pagination';
import EmptyState from '@/Shared/EmptyState';

export default {
    components: {
        Pagination, SearchFilter, EmptyState
    },

    mixins: [ModalHelpers],

    props: {
        filters: {
            type: Object,
            required: true
        },
        notes: {
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

    computed: {
        hasEmptyState () {
            return this.search == null && this.notes.meta.total === 0;
        }
    },

    watch: {
        form: {
            handler: 'refreshNotesList',
            deep: true
        }
    },

    methods: {
        confirmRemove (note, toggle) {
            toggle();
            this.showModal(note);
        },

        duplicate (note) {
            this.$inertia.post(
                this.$route('notes.duplicate', { originalNote: note })
            );
        },

        refreshNotesList: debounce(function () {
            const query = pickBy(this.form);

            this.$inertia.replace(
                this.$route('notes.index', Object.keys(query).length ? query : { remember: 'forget' })
            );
        }, 250),

        remove () {
            this.$inertia.delete(
                this.$route('notes.destroy', { note: this.deletingItem })
            );
        }
    }
};
</script>
