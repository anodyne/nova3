<template>
	<div class="item-picker" v-on-clickaway="away">
		<div role="button"
			 class="selected-toggle"
			 v-if="selectedRank"
			 @click.prevent="show = !show">
			<div class="selected-item">
				<rank :item="selectedRank"></rank>
				<div class="ml-3" v-html="showIcon('more')"></div>
			</div>
			<small class="meta">{{ selectedRank.info.name }}</small>
			<input type="hidden" name="rank_id" v-model="selectedRank.id">
		</div>
		<div role="button"
			 class="selected-toggle"
			 v-if="!selectedRank"
			 @click.prevent="show = !show">
			<div class="selected-item">
				<rank></rank>
				<div class="ml-3" v-html="showIcon('more')"></div>
			</div>
		</div>

		<div v-show="show" class="items-menu">
			<div class="search-group">
				<span class="search-field">
					<div v-html="showIcon('search')"></div>
					<input type="text" placeholder="Find by name or group" v-model="search">
				</span>
				<a href="#"
				   class="clear-search ml-2"
				   @click.prevent="search = ''"
				   v-html="showIcon('close-alt')"></a>
			</div>

			<div class="items-menu-alert" v-show="filteredRanks.length == 0">
				<div class="alert alert-warning">No ranks found</div>
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
			selected: { type: Object }
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

				return this.ranks.filter(function (rank) {
					let searchRegex = new RegExp(self.search, 'i');

					return searchRegex.test(rank.info.name) || searchRegex.test(rank.group.name);
				});
			}
		},

		methods: {
			away () {
				this.show = false;
			},

			selectRank (rank) {
				this.selectedRank = rank;
				this.show = false;
				this.search = '';
			},

			showIcon (icon) {
				return window.icon(icon)
			}
		},

		created () {
			let self = this;

			if (this.selected) {
				this.selectedRank = this.selected;
			}

			axios.get(route('api.ranks')).then((response) => {
				self.ranks = response.data;
			});
		}
	}
</script>
