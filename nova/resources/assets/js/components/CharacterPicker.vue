<template>
	<div class="item-picker" v-on-clickaway="away">
		<div role="button"
			 class="selected-toggle"
			 v-if="selectedCharacter"
			 @click.prevent="show = !show">
			<div class="selected-item">
				<character-avatar :character="selectedCharacter" size="xs" type="image"></character-avatar>
				<i class="far fa-angle-down fa-fw ml-3"></i>
			</div>
			<input type="hidden" name="character_id" v-model="selectedCharacter.id">
		</div>
		<div role="button"
			 class="selected-toggle"
			 v-if="!selectedCharacter"
			 @click.prevent="show = !show">
			<div class="selected-item">
				<span>No character</span>
				<i class="far fa-angle-down fa-fw ml-3"></i>
			</div>
		</div>

		<div v-show="show" class="items-menu">
			<div class="search-group">
				<span class="search-field">
					<i class="far fa-search fa-fw"></i>
					<input type="text" placeholder="Find characters..." v-model="search">
				</span>
				<a href="#"
				   class="clear-search"
				   @click.prevent="search = ''">
				   <i class="far fa-times-circle fa-fw ml-2"></i>
				</a>
			</div>

			<div class="items-menu-alert" v-show="filteredCharacters.length == 0">
				<div class="alert alert-warning">No characters found</div>
			</div>

			<div class="items-menu-item" v-if="selectedCharacter != false" @click.prevent="selectCharacter(false)">
				No character
			</div>

			<div class="items-menu-item" v-for="character in filteredCharacters" @click.prevent="selectCharacter(character)">
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
			selected: {
				type: Object
			}
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

					return searchRegex.test(character.name)
						|| searchRegex.test(character.user.displayName)
						|| searchRegex.test(character.position.name);
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
			}
		},

		created () {
			let self = this;

			if (this.selected) {
				this.selectedCharacter = this.selected;
			}

			axios.get(route('api.characters')).then((response) => {
				self.characters = response.data;
			});
		}
	}
</script>
