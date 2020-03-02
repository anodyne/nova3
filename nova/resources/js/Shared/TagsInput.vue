<template>
    <dropdown
        v-model="showResultsPanel"
        placement="bottom-center"
        @keydown.down.prevent="highlightNext"
        @keydown.up.prevent="highlightPrevious"
        @keydown.enter.prevent="addHighlightedItem"
    >
        <div class="field-group flex-wrap" :class="{ 'py-1': items.length > 0 }">
            <div
                v-for="item in items"
                :key="item[keyProperty]"
                class="badge mr-2 my-1"
                data-cy="tag-item"
            >
                {{ item[displayProperty] }}

                <button
                    class="text-gray-500 ml-1 hover:text-gray-600"
                    type="button"
                    data-cy="remove-tag-item"
                    @click="removeItem(item)"
                >
                    <icon name="x" class="h-4 w-4"></icon>
                </button>
            </div>

            <input
                ref="search"
                v-model="searchTerm"
                type="text"
                class="field placeholder-gray-500"
                :placeholder="placeholder"
                data-cy="tags-search"
            >

            <button
                v-if="!!searchTerm"
                type="button"
                class="field-addon"
                data-cy="reset-tags-search"
                @click="resetSearch"
            >
                <icon name="x"></icon>
            </button>
        </div>

        <template #dropdown>
            <div v-show="showSearchingScreen" class="flex flex-col items-center py-8 leading-loose text-gray-300">
                <svg
                    class="block fill-current h-6 leading-none"
                    viewBox="0 0 120 30"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <circle
                        cx="15"
                        cy="15"
                        r="15"
                    >
                        <animate
                            attributeName="r"
                            from="15"
                            to="15"
                            begin="0s"
                            dur="0.8s"
                            values="15;9;15"
                            calcMode="linear"
                            repeatCount="indefinite"
                        />
                        <animate
                            attributeName="fill-opacity"
                            from="1"
                            to="1"
                            begin="0s"
                            dur="0.8s"
                            values="1;.5;1"
                            calcMode="linear"
                            repeatCount="indefinite"
                        />
                    </circle>
                    <circle
                        cx="60"
                        cy="15"
                        r="9"
                        fill-opacity="0.3"
                    >
                        <animate
                            attributeName="r"
                            from="9"
                            to="9"
                            begin="0s"
                            dur="0.8s"
                            values="9;15;9"
                            calcMode="linear"
                            repeatCount="indefinite"
                        />
                        <animate
                            attributeName="fill-opacity"
                            from="0.5"
                            to="0.5"
                            begin="0s"
                            dur="0.8s"
                            values=".5;1;.5"
                            calcMode="linear"
                            repeatCount="indefinite"
                        />
                    </circle>
                    <circle
                        cx="105"
                        cy="15"
                        r="15"
                    >
                        <animate
                            attributeName="r"
                            from="15"
                            to="15"
                            begin="0s"
                            dur="0.8s"
                            values="15;9;15"
                            calcMode="linear"
                            repeatCount="indefinite"
                        />
                        <animate
                            attributeName="fill-opacity"
                            from="1"
                            to="1"
                            begin="0s"
                            dur="0.8s"
                            values="1;.5;1"
                            calcMode="linear"
                            repeatCount="indefinite"
                        />
                    </circle>
                </svg>

                <p class="mt-4">Searching...</p>
            </div>
            <div>
                <ul
                    ref="items"
                    class="picker-select-items"
                    data-cy="tags-search-results"
                >
                    <li
                        v-for="(result, index) in results"
                        :key="result[keyProperty]"
                        class="picker-select-item"
                        :class="{ 'is-active': index === highlightedIndex }"
                        data-cy="tags-search-results-item"
                        @click="addItem(result)"
                    >
                        {{ result[displayProperty] }}
                    </li>
                </ul>

                <div v-if="results.length === 0" class="text-gray-300">
                    {{ notFoundMessage }}
                </div>
            </div>
        </template>
    </dropdown>
</template>

<script>
import debounce from 'lodash/debounce';
import Mousetrap from 'mousetrap';
import axios from '@/Utils/axios';

export default {
    name: 'TagsInput',

    model: {
        prop: 'items',
        event: 'input'
    },

    props: {
        displayProperty: {
            type: String,
            default: 'name'
        },
        items: {
            type: [String, Array, Object],
            required: true
        },
        keyProperty: {
            type: String,
            default: 'id'
        },
        notFoundMessage: {
            type: String,
            default: 'Sorry, no items found.'
        },
        placeholder: {
            type: String,
            default: 'Add item...'
        },
        searchUrl: {
            type: String,
            required: true
        }
    },

    data () {
        return {
            highlightedIndex: 0,
            isSearching: false,
            notFound: false,
            results: [],
            searchTerm: '',
            showResultsPanel: false,
            showSearchingScreen: false
        };
    },

    computed: {
        showResultsPanel1 () {
            return this.showSearchingScreen
                || this.results.length > 0
                || this.notFound;
        }
    },

    watch: {
        searchTerm: 'searchForResource'
    },

    mounted () {
        Mousetrap(this.$refs.search).bind('backspace', () => {
            if (this.items.length > 0 && this.searchTerm === '') {
                this.removeItem(this.items[this.items.length - 1]);
            }
        });
    },

    methods: {
        addHighlightedItem () {
            this.addItem(this.results[this.highlightedIndex]);
        },

        addItem (item) {
            this.$emit('add-item', item);

            this.resetHighlighted();
            this.resetSearch();
        },

        highlight (index) {
            this.highlightedIndex = index;

            if (this.highlightedIndex > this.results.length - 1) {
                this.highlightedIndex = 0;
            }

            if (this.highlightedIndex < 0) {
                this.highlightedIndex = this.results.length - 1;
            }

            this.scrollToHighlighted();
        },

        highlightNext () {
            this.highlight(this.highlightedIndex + 1);
        },

        highlightPrevious () {
            this.highlight(this.highlightedIndex - 1);
        },

        removeItem (item) {
            this.$emit('remove-item', item);
        },

        resetHighlighted () {
            this.highlightedIndex = 0;
        },

        resetSearch () {
            this.showResultsPanel = false;
            this.searchTerm = '';
            this.results = [];
            this.notFound = false;
        },

        scrollToHighlighted () {
            this.$refs.items.children[this.highlightedIndex].scrollIntoView({
                block: 'nearest'
            });
        },

        searchForResource: debounce(function () {
            if (this.searchTerm !== '') {
                this.isSearching = true;

                setTimeout(() => {
                    if (this.isSearching === true) {
                        this.showSearchingScreen = true;
                    }
                }, 1000);

                axios.get(`${this.searchUrl}?search=${this.searchTerm}`)
                    .then(({ data }) => {
                        this.results = data;
                    })
                    .catch((error) => {
                        //
                    })
                    .finally(() => {
                        this.showResultsPanel = true;
                        this.notFound = this.results.length === 0;
                        this.isSearching = false;
                        this.showSearchingScreen = false;
                    });
            } else {
                this.resetSearch();
            }
        }, 250)
    }
};
</script>
