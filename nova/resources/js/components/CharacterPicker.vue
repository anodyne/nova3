<template>
	<div class="item-picker" v-on-clickaway="away">
		<div class="item-picker-selector">
			<div role="button"
				 class="item-picker-toggle"
				 v-if="selectedCharacter"
				 @click.prevent="show = !show">
				<div class="item-picker-selected">
					<avatar :item="selectedCharacter" :show-status="showStatus" size="sm" type="image"></avatar>
					<div class="ml-3" v-html="showIcon('more')"></div>
				</div>
				<input type="hidden" :name="fieldName" v-model="selectedCharacter.id">
			</div>
			<div role="button"
				 class="item-picker-toggle"
				 v-if="!selectedCharacter"
				 @click.prevent="show = !show">
				<div class="item-picker-selected">
					<span v-text="lang('characters-none')"></span>
					<div class="ml-3" v-html="showIcon('more')"></div>
				</div>
				<input type="hidden" :name="fieldName" value="">
			</div>

			<slot></slot>
		</div>

		<div v-show="show" class="items-menu">
			<div class="search-group">
				<span class="search-field">
					<div v-html="showIcon('search')"></div>
					<input type="text" :placeholder="lang('characters-find')" v-model="search">
				</span>
				<a href="#"
				   class="clear-search ml-2"
				   @click.prevent="search = ''"
				   v-html="showIcon('close-alt')"></a>
			</div>

			<div class="items-menu-alert" v-show="filteredCharacters.length == 0">
				<div class="alert alert-warning" v-text="lang('characters-error-not-found')"></div>
			</div>

			<div class="items-menu-item"
				 v-if="selectedCharacter != false"
				 v-text="lang('characters-none')"
				 @click.prevent="selectCharacter(false)"></div>

			<div class="items-menu-item" v-for="character in filteredCharacters" @click.prevent="selectCharacter(character)">
				<avatar :item="character" :show-status="showStatus" size="sm" type="image"></avatar>
			</div>
		</div>
	</div>
</template>

<script>
	import Avatar from './Avatar.vue';
	import { mixin as clickaway } from 'vue-clickaway';

	export default {
		props: {
			fieldName: { type: String, default: 'character_id' },
			filter: { type: String },
			items: { type: Array },
			selected: { type: Object },
			showStatus: { type: Boolean, default: false }
		},

		components: { Avatar },

		mixins: [ clickaway ],

		data () {
			return {
				characters: [],
				search: '',
				selectedCharacter: false,
				show: false
			}
		},

		computed: {
			filteredCharacters () {
				let self = this;
				let filteredCharacters = this.characters;

				if (this.filter == 'unassigned') {
					filteredCharacters = filteredCharacters.filter((character) => {
						return character.user_id == null;
					});
				}

				return filteredCharacters.filter((character) => {
					let searchRegex = new RegExp(self.search, 'i');
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

		methods: {
			away () {
				this.show = false;
			},

			fetch () {
				let self = this;

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
				let classes = ['status', 'sm', 'mr-2'];

				if (character.user && !character.isPrimaryCharacter) {
					classes.push('secondary');
				}

				if (character.user && character.isPrimaryCharacter) {
					classes.push('primary');
				}

				return classes;
			}
		},

		created () {
			let self = this;

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
		}
	};
</script>
