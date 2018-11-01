<template>
    <div
        v-on-clickaway="away"
        class="item-picker"
    >
        <div class="item-picker-selector">
            <div
                v-if="selectedRank"
                role="button"
                class="item-picker-toggle"
                @click.prevent="show = !show"
            >
                <div class="item-picker-selected">
                    <div class="spread">
                        <rank :item="selectedRank"/>
                        <small
                            class="meta"
                            v-text="selectedRank.info.name"
                        />
                    </div>
                    <div
                        class="ml-3"
                        v-html="showIcon('more')"
                    />
                </div>
                <input
                    v-model="selectedRank.id"
                    type="hidden"
                    name="rank_id"
                >
            </div>
            <div
                v-if="!selectedRank"
                role="button"
                class="item-picker-toggle"
                @click.prevent="show = !show"
            >
                <div class="item-picker-selected">
                    <rank/>
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
                        :placeholder="lang('genre-ranks-find')"
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
                v-show="filteredRanks.length == 0"
                class="items-menu-alert"
            >
                <div
                    class="alert alert-warning"
                    v-text="lang('genre-ranks-error-not-found')"
                />
            </div>

            <div
                v-if="selectedRank != false"
                class="items-menu-item"
                @click.prevent="selectRank(false)"
            >
                <rank/>
                <small
                    class="meta"
                    v-text="lang('genre-ranks-none')"
                />
            </div>

            <div
                v-for="rank in filteredRanks"
                :key="rank.id"
                class="items-menu-item"
                @click.prevent="selectRank(rank)"
            >
                <rank :item="rank"/>
                <small class="meta">{{ rank.info.name }}</small>
            </div>
        </div>
    </div>
</template>

<script>
import { mixin as clickaway } from 'vue-clickaway';
import Rank from './Rank.vue';

export default {
    components: { Rank },

    mixins: [clickaway],

    props: {
        character: {
            type: Object,
            required: false,
            default: null
        },
        initialRanks: {
            type: Array,
            required: false,
            default: null
        },
        selected: {
            type: Object,
            required: false,
            default: null
        }
    },

    data () {
        return {
            ranks: [],
            search: '',
            selectedRank: false,
            show: false
        };
    },

    computed: {
        filteredRanks () {
            return this.ranks.filter((rank) => {
                const searchRegex = new RegExp(this.search, 'i');

                return searchRegex.test(rank.info.name) || searchRegex.test(rank.group.name);
            });
        }
    },

    created () {
        if (this.selected) {
            this.selectedRank = this.selected;
        }

        if (this.initialRanks !== null) {
            this.ranks = this.initialRanks;
        } else {
            Nova.request({
                url: route('api.ranks'),
                method: 'get'
            }).then((response) => {
                this.ranks = response.data;
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

        selectRank (rank) {
            this.selectedRank = rank;
            this.show = false;
            this.search = '';

            Nova.$emit('rank-picker-selected', this.selectedRank, this.character);
        },

        showIcon (icon) {
            return window.icon(icon);
        }
    }
};
</script>
