<template>
    <div class="item-picker">
        <div class="item-picker-selector">
            <div
                role="button"
                class="item-picker-toggle"
                @click.prevent="show = !show"
            >
                <div class="item-picker-selected">
                    <div
                        v-if="selectedItem"
                        class="spread"
                    >
                        <slot
                            :item="selectedItem"
                            name="picker-selected-item"
                        />
                    </div>
                    <div v-else>
                        <slot name="picker-nothing-selected"/>
                    </div>
                    <div class="ml-3 leading-0">
                        <icon
                            name="chevron-down"
                            size="small"
                        />
                    </div>
                </div>

                <slot
                    :item="selectedItem"
                    name="picker-field"
                />
            </div>

            <slot/>
        </div>

        <div
            v-show="show"
            class="items-menu"
        >
            <div class="search-group">
                <span class="search-field">
                    <icon name="search"/>
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Find..."
                    >
                </span>
                <a
                    href="#"
                    class="clear-search ml-2 leading-0"
                    @click.prevent="search = ''"
                >
                    <icon name="close-alt" />
                </a>
            </div>

            <div
                v-show="filteredItems.length == 0"
                class="items-menu-alert"
            >
                <div class="alert alert-warning">
                    <slot name="picker-list-empty-message"/>
                </div>
            </div>

            <!--<div class="items-menu-item" v-if="selectedItem != false" @click.prevent="select(false)">
				<rank></rank>
				<small class="meta" v-text="lang('genre-ranks-none')"></small>
			</div>-->

            <div
                v-for="item in filteredItems"
                :key="item.id"
                class="items-menu-item"
                @click.prevent="select(item)"
            >
                <slot
                    :item="item"
                    name="picker-list-item"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Icon from '../Icon.vue';

export default {

    components: { Icon },
    props: {
        items: { type: Array, required: true },
        selected: { type: Object },
        showSearch: { type: Boolean, default: true }
    },

    data () {
        return {
            search: '',
            selectedItem: this.selected,
            show: false
        };
    },

    computed: {
        filteredItems () {
            return this.items;
            return this.items.filter((item) => {
                const searchRegex = new RegExp(this.search, 'i');

                // TODO: Need a better way to handle which items we're potentially searching by
                // return searchRegex.test(item.info.name) || searchRegex.test(item.group.name)
            });
        }
    },

    methods: {
        reset () {
            this.search = '';
            this.show = false;
        },

        select (item) {
            this.selectedItem = item;
            this.reset();

            // TODO: Need a better way to handle emitting a selected event and the different data we may need to emit
            this.$events.$emit('picker-item-selected', this.selectedItem);
        }
    }
};
</script>
