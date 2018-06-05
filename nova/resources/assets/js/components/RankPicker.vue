<template>
	<div class="item-picker" v-on-clickaway="away">
		<div class="item-picker-selector">
			<div role="button"
				 class="item-picker-toggle"
				 v-if="selectedRank"
				 @click.prevent="show = !show">
				<div class="item-picker-selected">
					<div class="spread">
						<rank :item="selectedRank"></rank>
						<small class="meta" v-text="selectedRank.info.name"></small>
					</div>
					<div class="ml-3" v-html="showIcon('more')"></div>
				</div>
				<input type="hidden" name="rank_id" v-model="selectedRank.id">
			</div>
			<div role="button"
				 class="item-picker-toggle"
				 v-if="!selectedRank"
				 @click.prevent="show = !show">
				<div class="item-picker-selected">
					<rank></rank>
					<div class="ml-3" v-html="showIcon('more')"></div>
				</div>
			</div>

			<slot></slot>
		</div>

		<div v-show="show" class="items-menu">
			<div class="search-group">
				<span class="search-field">
					<div v-html="showIcon('search')"></div>
					<input type="text" :placeholder="lang('genre-ranks-find')" v-model="search">
				</span>
				<a href="#"
				   class="clear-search ml-2"
				   @click.prevent="search = ''"
				   v-html="showIcon('close-alt')"></a>
			</div>

			<div class="items-menu-alert" v-show="filteredRanks.length == 0">
				<div class="alert alert-warning" v-text="lang('genre-ranks-error-not-found')"></div>
			</div>

			<div class="items-menu-item" v-if="selectedRank != false" @click.prevent="selectRank(false)">
				<rank></rank>
				<small class="meta" v-text="lang('genre-ranks-none')"></small>
			</div>

			<div class="items-menu-item" v-for="rank in filteredRanks" @click.prevent="selectRank(rank)">
				<rank :item="rank"></rank>
				<small class="meta">{{ rank.info.name }}</small>
			</div>
		</div>
	</div>
</template>

<script>
	import Rank from './Rank.vue';
	import { mixin as clickaway } from 'vue-clickaway';

	export default {
		components: { Rank },

		props: {
			character: { type: Object, required: false, default: null },
			initialRanks: { type: Array, required: false, default: null },
			selected: { type: Object, required: false, default: null }
		},

		mixins: [ clickaway ],

		data () {
			return {
				ranks: [],
				search: '',
				selectedRank: false,
				show: false
			}
		},

		computed: {
			filteredRanks () {
				let self = this;

				return this.ranks.filter((rank) => {
					let searchRegex = new RegExp(self.search, 'i');

					return searchRegex.test(rank.info.name) || searchRegex.test(rank.group.name);
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

				this.$events.$emit('rank-picker-selected', this.selectedRank, this.character);
			},

			showIcon (icon) {
				return window.icon(icon);
			}
		},

		created () {
			let self = this;

			if (this.selected) {
				this.selectedRank = this.selected;
			}

			if (this.initialRanks != null) {
				this.ranks = this.initialRanks;
			} else {
				axios.get(route('api.ranks')).then((response) => {
					self.ranks = response.data;
				});
			}
		}
	};
</script>
