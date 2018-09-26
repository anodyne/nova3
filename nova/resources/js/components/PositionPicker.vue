<template>
    <div
        v-on-clickaway="away"
        class="item-picker"
    >
        <div class="item-picker-selector">
            <div
                v-if="selectedPosition"
                role="button"
                class="item-picker-toggle"
                @click.prevent="show = !show"
            >
                <div class="item-picker-selected">
                    <div class="stacked">
                        <span v-text="selectedPosition.name"/>
                        <small
                            class="meta"
                            v-text="selectedPosition.department.name"
                        />
                    </div>
                    <div
                        class="ml-3"
                        v-html="showIcon('more')"
                    />
                </div>
                <input
                    v-model="selectedPosition.id"
                    type="hidden"
                    name="positions[]"
                >
            </div>
            <div
                v-if="!selectedPosition"
                role="button"
                class="item-picker-toggle"
                @click.prevent="show = !show"
            >
                <div class="item-picker-selected">
                    <span v-text="lang('genre-positions-select')"/>
                    <div
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
                        :placeholder="lang('genre-positions-find')"
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
                v-show="filteredPositions.length == 0"
                class="items-menu-alert"
            >
                <div
                    class="alert alert-warning"
                    v-text="lang('genre-positions-error-not-found')"
                />
            </div>

            <div
                v-for="position in filteredPositions"
                :key="position.id"
                class="items-menu-item stacked"
                @click.prevent="selectPosition(position)"
            >
                <span v-text="position.name"/>
                <small
                    class="meta"
                    v-text="position.department.name"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { mixin as clickaway } from 'vue-clickaway';

export default {

    mixins: [clickaway],
    props: {
        items: {
            type: Array,
            default: () => []
        },
        onlyAvailable: {
            type: Boolean,
            default: true
        },
        selected: {
            type: Object,
            required: false,
            default: () => ({})
        }
    },

    data () {
        return {
            positions: [],
            search: '',
            selectedPosition: false,
            show: false
        };
    },

    computed: {
        filteredPositions () {
            let { positions } = this;

            if (this.onlyAvailable) {
                positions = positions.filter((position) => {
                    return parseInt(position.available, 10) > 0);
                }
            }

            return positions.filter((position) => {
                const searchRegex = new RegExp(this.search, 'i');

                return searchRegex.test(position.name)
                    || searchRegex.test(position.department.name);
            });
        }
    },

    created () {
        if (this.selected) {
            this.selectedPosition = this.selected;
        }

        if (this.items && this.items.length > 0) {
            this.positions = this.items;
        } else {
            Nova.request({
                url: route('api.positions'),
                method: 'get'
            }).then((response) => {
                this.positions = response.data;
            });
        }
    },

    methods: {
        away () {
            this.show = false;
        },

        lang (key, attributes = '') {
            return window.lang(key, attributes);
        },

        selectPosition (position) {
            this.selectedPosition = position;
            this.show = false;
            this.search = '';
        },

        showIcon (icon) {
            return window.icon(icon);
        }
    }
};
</script>
