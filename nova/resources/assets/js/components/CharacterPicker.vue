<template>
	<div class="item-picker" v-on-clickaway="away">
		<div role="button"
			 class="selected-toggle"
			 v-if="selectedCharacter"
			 @click.prevent="show = !show">
			<div class="selected-item">
				<span :class="statusClasses(selectedCharacter)" v-if="showStatus"></span>
				<character-avatar :character="selectedCharacter" size="xs" type="image"></character-avatar>
				<div class="ml-3" v-html="showIcon('more')"></div>
			</div>
			<input type="hidden" :name="fieldName" v-model="selectedCharacter.id">
		</div>
		<div role="button"
			 class="selected-toggle"
			 v-if="!selectedCharacter"
			 @click.prevent="show = !show">
			<div class="selected-item">
				<span>No character</span>
				<div class="ml-3" v-html="showIcon('more')"></div>
			</div>
			<input type="hidden" :name="fieldName" value="">
		</div>

		<div v-show="show" class="items-menu">
			<div class="search-group">
				<span class="search-field">
					<div v-html="showIcon('search')"></div>
					<input type="text" placeholder="Find characters..." v-model="search">
				</span>
				<a href="#"
				   class="clear-search ml-2"
				   @click.prevent="search = ''"
				   v-html="showIcon('close-alt')"></a>
			</div>

			<div class="items-menu-alert" v-show="filteredCharacters.length == 0">
				<div class="alert alert-warning">No characters found</div>
			</div>

			<div class="items-menu-item" v-if="selectedCharacter != false" @click.prevent="selectCharacter(false)">
				No character
			</div>

			<div class="items-menu-item" v-for="character in filteredCharacters" @click.prevent="selectCharacter(character)">
				<span :class="statusClasses(character)" v-if="showStatus"></span>
				<character-avatar :character="character" size="xs" type="image"></character-avatar>
			</div>
		</div>
	</div>
</template>

<script>
	import CharacterAvatar from './CharacterAvatar.vue';
	import { mixin as clickaway } from 'vue-clickaway';

	export default {
		props: {
			fieldName: { type: String, default: 'character_id' },
			items: { type: Array },
			selected: { type: Object },
			showStatus: { type: Boolean, default: false }
		},

		components: { CharacterAvatar },

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

				return this.characters.filter(function (character) {
					let searchRegex = new RegExp(self.search, 'i');
					let userSearch;

					if (character.user) {
						userSearch = searchRegex.test(character.user.displayName)
					}

					return searchRegex.test(character.name)
						|| searchRegex.test(character.position.name)
						|| userSearch;
				});
			}
		},

		methods: {
			away () {
				this.show = false;
			},

			selectCharacter (character) {
				this.selectedCharacter = character;
				this.show = false;
				this.search = '';
			},

			showIcon (icon) {
				return window.icon(icon)
			},

			statusClasses (character) {
				let classes = ['status', 'sm', 'mr-2']

				if (character.user && !character.isPrimaryCharacter) {
					classes.push('secondary')
				}

				if (character.user && character.isPrimaryCharacter) {
					classes.push('primary')
				}

				return classes
			}
		},

		created () {
			let self = this;

			if (this.selected) {
				this.selectedCharacter = this.selected;
			}

			if (this.items) {
				this.characters = this.items;
			} else {
				axios.get(route('api.characters')).then((response) => {
					self.characters = response.data;
				});
			}
		}
	}
</script>
