<template>
    <sidebar-layout>
        <page-header title="Notes">
            <inertia-link
                slot="controls"
                :href="$route('notes.create')"
                class="button button-primary"
            >
                Add Note
            </inertia-link>
        </page-header>

        <panel no-padding>
            <template #header>
                <search-filter
                    v-model="form.search"
                    class="w-1/2"
                    placeholder="Find a note..."
                    @reset="form.search = ''"
                ></search-filter>
            </template>

            <div class="flex items-center justify-between w-full py-2 px-8 bg-gray-100 border-t border-b text-xs uppercase tracking-wide font-medium text-gray-600">
                <div class="w-1/2">Note Title</div>
            </div>

            <div v-if="notes.data.length === 0" class="flex items-center py-4 px-8 font-semibold border-b text-warning-700">
                <icon name="alert-triangle" class="mr-3 flex-shrink-0 h-6 w-6"></icon>
                <div>No notes found.</div>
            </div>

            <div
                v-for="note in notes.data"
                :key="note.id"
                class="flex items-center justify-between w-full py-2 px-8 border-b"
            >
                <div class="w-1/2">
                    {{ note.title }}
                </div>

                <div class="flex-shrink">
                    <dropdown placement="bottom-end">
                        <icon name="more-horizontal" class="h-6 w-6"></icon>

                        <template #dropdown="{ toggle }">
                            <inertia-link
                                :href="$route('notes.show', { note })"
                                class="dropdown-link"
                            >
                                <icon name="eye" class="dropdown-icon"></icon>
                                View
                            </inertia-link>
                            <inertia-link
                                :href="$route('notes.edit', { note })"
                                class="dropdown-link"
                            >
                                <icon name="edit" class="dropdown-icon"></icon>
                                Edit
                            </inertia-link>
                            <button
                                class="dropdown-link"
                                @click.prevent="duplicate(note)"
                            >
                                <icon name="copy" class="dropdown-icon"></icon>
                                Duplicate
                            </button>
                            <button
                                class="dropdown-link-danger"
                                @click.prevent="confirmRemove(note, toggle)"
                            >
                                <icon name="trash" class="dropdown-icon"></icon>
                                Delete
                            </button>
                        </template>
                    </dropdown>
                </div>
            </div>

            <template v-if="notes.meta.total > 0" #footer>
                <pagination
                    :links="notes.links"
                    :meta="notes.meta"
                    resource-label="note"
                ></pagination>
            </template>
        </panel>

        <modal
            :open="modalIsShown"
            title="Delete Note"
            @close="hideModal"
        >
            Are you sure you want to delete the <strong>{{ deletingItem.title }}</strong> note? This change is permanent and cannot be undone.

            <template #footer>
                <button class="button" @click="hideModal">
                    Cancel
                </button>

                <button
                    type="button"
                    class="button button-danger ml-4"
                    @click="remove"
                >
                    Delete Note
                </button>
            </template>
        </modal>
    </sidebar-layout>
</template>

<script>
import pickBy from 'lodash/pickBy';
import debounce from 'lodash/debounce';
import SearchFilter from '@/Shared/SearchFilter';
import ModalHelpers from '@/Utils/Mixins/ModalHelpers';
import Pagination from '@/Shared/Pagination';

export default {
    components: {
        Pagination, SearchFilter
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
