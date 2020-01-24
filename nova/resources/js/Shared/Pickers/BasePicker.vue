<template>
    <div
        v-click-outside="close"
        class="picker"
        :class="{ 'is-active': isOpen }"
        @keydown.escape.prevent="close"
        @keydown.down.prevent="highlightNext"
        @keydown.up.prevent="highlightPrevious"
        @keydown.enter.prevent="selectHighlighted"
        @keydown.tab.prevent="close"
    >
        <button
            ref="trigger"
            type="button"
            class="picker-select-input"
            @click="toggle"
        >
            <div>
                <div v-if="hasValue" class="flex-1 flex items-center">
                    <slot :selected="selected" name="picker-select-input">
                        {{ selected }}
                    </slot>
                </div>
                <div v-else class="picker-select-placeholder">
                    {{ placeholderEmptyState }}
                </div>
            </div>
            <icon name="chevron-down" class="picker-caret"></icon>
        </button>

        <div
            v-show="isOpen"
            ref="dropdown"
            class="picker-select-dropdown"
        >
            <div v-if="isSearchable">
                <input
                    ref="search"
                    v-model="search"
                    type="text"
                    class="picker-select-search"
                    :placeholder="placeholderSearch"
                >
            </div>

            <ul
                v-if="filteredItems.length > 0"
                ref="items"
                class="picker-select-items"
            >
                <li
                    v-for="(item, index) in filteredItems"
                    :key="item.id"
                    class="picker-select-item"
                    :class="{ 'is-active': index === highlightedIndex }"
                    @click="select(item)"
                >
                    <slot :item="item" name="picker-select-item"></slot>
                </li>
            </ul>

            <div v-if="filteredItems.length === 0" class="picker-select-empty">
                No results found for "{{ search }}".
            </div>
        </div>
    </div>
</template>

<script>
import { createPopper } from '@popperjs/core';

export default {
    name: 'BasePicker',

    props: {
        filterFunction: {
            type: Function,
            default: null
        },
        items: {
            type: Array,
            default: () => []
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

    data () {
        return {
            highlightedIndex: 0,
            isOpen: false,
            search: '',
            selected: this.value
        };
    },

    computed: {
        filteredItems () {
            if (this.isSearchable) {
                return this.filterFunction(this.search, this.items);
            }

            return this.items;
        },

        hasValue () {
            return !!this.value;
        },

        isSearchable () {
            return this.filterFunction !== null;
        }
    },

    watch: {
        value (newValue) {
            this.selected = newValue;
        }
    },

    beforeDestroy () {
        if (this.popper) {
            this.popper.destroy();
        }
    },

    methods: {
        close () {
            if (!this.isOpen) {
                return;
            }

            this.isOpen = false;

            this.$refs.trigger.focus();

            this.$emit('closed');
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

        highlightPrevious () {
            this.highlight(this.highlightedIndex - 1);
        },

        open () {
            if (this.isOpen) {
                return;
            }

            this.isOpen = true;

            this.$emit('opened');

            this.$nextTick(() => {
                this.setupPopper();

                if (this.isSearchable) {
                    this.$refs.search.focus();
                }

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
                this.popper = createPopper(this.$refs.trigger, this.$refs.dropdown, {
                    placement: 'bottom',
                    positionFixed: true,
                    modifiers: {
                        flip: {
                            boundariesElement: 'viewport'
                        },
                        preventOverflow: {
                            boundariesElement: 'viewport'
                        },
                        autoSizing: {
                            enabled: true,
                            fn: (data) => {
                                const newData = data;

                                newData.offsets.popper.left = newData.offsets.reference.left;
                                newData.offsets.popper.right = newData.offsets.reference.right;
                                newData.styles.width = newData.offsets.reference.width;
                                newData.offsets.popper.width = newData.styles.width;

                                return newData;
                            },
                            order: 840
                        }
                    }
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
