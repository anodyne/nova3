<template>
    <div
        class="picker"
        :class="{ 'is-active': isOpen }"
        v-click-outside="close"
    >
        <button
            type="button"
            class="picker-select-input"
            @click="toggle"
            ref="trigger"
        >
            <div>
                <div class="flex-1 flex items-center" v-if="hasValue">
                    <slot :selected="value" name="picker-select-input">
                        {{ value }}
                    </slot>
                </div>
                <div class="picker-select-placeholder" v-else>
                    {{ placeholderEmptyState }}
                </div>
            </div>
            <app-icon name="chevron-down" class="h-4 w-4 text-grey-dark"></app-icon>
        </button>

        <div
            class="picker-select-dropdown"
            v-show="isOpen"
            ref="dropdown"
        >
            <div v-if="isSearchable">
                <input
                    type="text"
                    v-model="search"
                    class="picker-select-search"
                    :placeholder="placeholderSearch"
                    ref="search"
                    @keydown.escape="close"
                    @keydown.down="highlightNext"
                    @keydown.up="highlightPrev"
                    @keydown.enter.prevent="selectHighlighted"
                    @keydown.tab="close"
                >
            </div>

            <ul
                class="picker-select-items"
                v-show="filteredItems.length > 0"
                ref="items"
            >
                <li
                    class="picker-select-item"
                    :class="{ 'is-active': index === highlightedIndex }"
                    v-for="(item, index) in filteredItems"
                    :key="item.id"
                    @click="select(item)"
                >
                    <slot :item="item" name="picker-select-item"></slot>
                </li>
            </ul>

            <div class="picker-select-empty" v-show="filteredItems.length === 0">
                No results found for "{{ search }}".
            </div>
        </div>
    </div>
</template>

<script>
import Popper from 'popper.js';

export default {
    name: 'BasePicker',

    props: {
        filterFunction: {
            type: Function,
            default: (search, items) => {
                return items.filter((item) => {
                    const searchRegex = new RegExp(search, 'i');

                    return searchRegex.test(item.name);
                });
            }
        },

        isSearchable: {
            type: Boolean,
            default: true
        },

        items: {
            type: Array,
            default: () => { return []; }
        },

        placeholderEmptyState: {
            type: String,
            default: 'Select an item...'
        },

        placeholderSearch: {
            type: String,
            default: 'Find an item...'
        },

        value: {
            type: [String, Object, Number],
            default: null
        }
    },

    beforeDestroy () {
        this.popper.destroy();
    },

    computed: {
        filteredItems () {
            return this.filterFunction(this.search, this.items);
        },

        hasValue () {
            return this.value !== null;
        }
    },

    data () {
        return {
            highlightedIndex: 0,
            isOpen: false,
            search: ''
        }
    },

    methods: {
        close () {
            if (! this.isOpen) {
                return;
            }

            this.isOpen = false;

            this.$refs.trigger.focus();
        },

        highlight (index) {
            this.highlightedIndex = index;

            if (this.highlightedIndex > this.filteredItems.length - 1) {
                this.highlightedIndex = 0;
            }

            if (this.highlightedIndex < 0) {
                this.highlightedIndex = this.filteredItems.length - 1;
            }

            this.scrollToHighlighted();
        },

        highlightNext () {
            this.highlight(this.highlightedIndex + 1);
        },

        highlightPrev () {
            this.highlight(this.highlightedIndex - 1);
        },

        open () {
            if (this.isOpen) {
                return;
            }

            this.isOpen = true;

            this.$nextTick(() => {
                this.setupPopper();

                this.$refs.search.focus();

                this.scrollToHighlighted();
            });
        },

        resetHighlighted () {
            this.highlightedIndex = 0;
        },

        resetSearch () {
            this.search = '';
        },

        scrollToHighlighted () {
            this.$refs.items.children[this.highlightedIndex].scrollIntoView({
                block: 'nearest'
            });
        },

        select (item) {
            this.$emit('input', item);

            this.resetHighlighted();
            this.resetSearch();

            this.close();
        },

        selectHighlighted () {
            this.select(this.filteredItems[this.highlightedIndex]);
        },

        setupPopper () {
            if (this.popper === undefined) {
                this.popper = new Popper(this.$refs.trigger, this.$refs.dropdown, {
                    placement: 'bottom'
                });
            } else {
                this.popper.scheduleUpdate();
            }
        },

        toggle () {
            if (this.isOpen) {
                this.close();
            } else {
                this.open();
            }
        }
    }
};
</script>