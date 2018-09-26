<template>
    <div
        v-on-clickaway="away"
        class="item-picker"
    >
        <div class="item-picker-selector">
            <div
                v-if="selectedCharacter"
                role="button"
                class="item-picker-toggle"
                @click.prevent="show = !show"
            >
                <div class="item-picker-selected">
                    <avatar
                        :item="selectedCharacter"
                        :show-status="showStatus"
                        size="sm"
                        type="image"
                    />
                    <div
                        class="ml-3"
                        v-html="showIcon('more')"
                    />
                </div>
                <input
                    :name="fieldName"
                    v-model="selectedCharacter.id"
                    type="hidden"
                >
            </div>
            <div
                v-if="!selectedCharacter"
                role="button"
                class="item-picker-toggle"
                @click.prevent="show = !show"
            >
                <div class="item-picker-selected">
                    <span v-text="lang('characters-none')"/>
                    <div
                        class="ml-3"
                        v-html="showIcon('more')"
                    />
                </div>
                <input
                    :name="fieldName"
                    type="hidden"
                    value=""
                >
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
                        :placeholder="lang('characters-find')"
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
                v-show="filteredCharacters.length == 0"
                class="items-menu-alert"
            >
                <div
                    class="alert alert-warning"
                    v-text="lang('characters-error-not-found')"
                />
            </div>

            <div
                v-if="selectedCharacter != false"
                class="items-menu-item"
                @click.prevent="selectCharacter(false)"
                v-text="lang('characters-none')"
            />

            <div
                v-for="character in filteredCharacters"
                class="items-menu-item"
                @click.prevent="selectCharacter(character)"
            >
                <avatar
                    :item="character"
                    :show-status="showStatus"
                    size="sm"
                    type="image"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { mixin as clickaway } from 'vue-clickaway';
import Avatar from './Avatar.vue';

export default {

    components: { Avatar },

    mixins: [clickaway],
    props: {
        fieldName: { type: String, default: 'character_id' },
        filter: { type: String },
        items: { type: Array },
        selected: { type: Object },
        showStatus: { type: Boolean, default: false }
    },

	data () {
        return {
            characters: [],
            search: '',
            selectedCharacter: false,
            show: false,
        };
    },

    computed: {
        filteredCharacters () {
            const self = this;
            let filteredCharacters = this.characters;

            if (this.filter == 'unassigned') {
                filteredCharacters = filteredCharacters.filter((character) => { return character.user_id == null; });
            }

            return filteredCharacters.filter((character) => {
                const searchRegex = new RegExp(self.search, 'i');
                let userSearch;

                if (character.user) {
                    userSearch = searchRegex.test(character.user.name);
                }

                return searchRegex.test(character.displayName)
						|| searchRegex.test(character.primaryPosition.name)
						|| userSearch;
            });
        }
    },

    created () {
        const self = this;

        if (this.selected) {
            this.selectedCharacter = this.selected;
        }

        this.fetch();

        this.$events.$on('character-picker-refresh', () => {
            self.fetch();
        });

        this.$events.$on('character-picker-reset', () => {
            self.selectedCharacter = false;
        });
    },

    methods: {
        away () {
            this.show = false;
        },

        fetch () {
            const self = this;

            if (this.items) {
                this.characters = this.items;
            } else {
                axios.get(route('api.characters')).then((response) => {
                    self.characters = response.data;
                });
            }
        },

        lang (key, attributes = '') {
            return window.lang(key, attributes);
        },

        selectCharacter (character) {
            this.selectedCharacter = character;
            this.show = false;
            this.search = '';

            this.$events.$emit('character-picker-selected', this.selectedCharacter);
        },

        showIcon (icon) {
            return window.icon(icon);
        },

        statusClasses (character) {
            const classes = ['status', 'sm', 'mr-2'];

            if (character.user && !character.isPrimaryCharacter) {
                classes.push('secondary');
            }

            if (character.user && character.isPrimaryCharacter) {
                classes.push('primary');
            }

            return classes;
        }
    }
};
</script>
