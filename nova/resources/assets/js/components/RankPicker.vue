<template>
	<div class="rank-picker" v-on-clickaway="away">
		<div role="button"
			 class="selected-toggle"
			 v-if="selectedRank"
			 @click.prevent="show = !show">
			<div class="selected-rank">
				<rank :item="selectedRank"></rank>
				<i class="far fa-angle-down fa-fw ml-3"></i>
			</div>
			<small class="meta">{{ selectedRank.info.name }}</small>
			<input type="hidden" name="rank_id" v-model="selectedRank.id">
		</div>
		<div role="button"
			 class="selected-toggle"
			 v-if="!selectedRank"
			 @click.prevent="show = !show">
			<div class="selected-rank">
				<rank></rank>
				<i class="far fa-angle-down fa-fw ml-3"></i>
			</div>
		</div>

		<div v-show="show" class="ranks-menu">
			<div class="rank-search-group">
				<span class="rank-search-field">
					<i class="far fa-search fa-fw"></i>
					<input type="text" placeholder="Find by name or group" v-model="search">
				</span>
				<a href="#"
				   class="clear-search"
				   @click.prevent="search = ''">
				   <i class="far fa-times-circle fa-fw ml-2"></i>
				</a>
			</div>

			<div class="rank-menu-alert" v-show="filteredRanks.length == 0">
				<div class="alert alert-warning">No ranks found</div>
			</div>

			<div class="rank-menu-item" v-for="rank in filteredRanks" @click.prevent="selectRank(rank)">
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
			selected: {
				type: Object
			}
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
