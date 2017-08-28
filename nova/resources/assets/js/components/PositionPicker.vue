<template>
	<div class="item-picker" v-on-clickaway="away">
		<div class="item-picker-selector">
			<div role="button"
				 class="item-picker-toggle"
				 v-if="selectedPosition"
				 @click.prevent="show = !show">
				<div class="item-picker-selected">
					<div class="stacked">
						<span v-text="selectedPosition.name"></span>
						<small class="meta" v-text="selectedPosition.department.name"></small>
					</div>
					<div class="ml-3" v-html="showIcon('more')"></div>
				</div>
				<input type="hidden" name="positions[]" v-model="selectedPosition.id">
			</div>
			<div role="button"
				 class="item-picker-toggle"
				 v-if="!selectedPosition"
				 @click.prevent="show = !show">
				<div class="item-picker-selected">
					<span v-text="_m('genre-positions-select')"></span>
					<div class="ml-3" v-html="showIcon('more')"></div>
				</div>
			</div>

			<slot></slot>
		</div>

		<div v-show="show" class="items-menu">
			<div class="search-group">
				<span class="search-field">
					<div v-html="showIcon('search')"></div>
					<input type="text" :placeholder="_m('genre-positions-find')" v-model="search">
				</span>
				<a href="#"
				   class="clear-search ml-2"
				   @click.prevent="search = ''"
				   v-html="showIcon('close-alt')"></a>
			</div>

			<div class="items-menu-alert" v-show="filteredPositions.length == 0">
				<div class="alert alert-warning" v-text="_m('genre-positions-error-not-found')"></div>
			</div>

			<div class="items-menu-item stacked"
				 v-for="position in filteredPositions"
				 @click.prevent="selectPosition(position)">
				<span v-text="position.name"></span>
				<small class="meta" v-text="position.department.name"></small>
			</div>
		</div>
	</div>
</template>

<script>
	import { mixin as clickaway } from 'vue-clickaway';

	export default {
		props: {
			items: { type: Array },
			onlyAvailable: { type: Boolean, default: true },
			selected: { type: Object, required: false }
		},

		mixins: [ clickaway ],

		data () {
			return {
				positions: [],
				search: '',
				selectedPosition: false,
				show: false
			}
		},

		computed: {
			filteredPositions () {
				let self = this;
				let positions = this.positions;

				if (this.onlyAvailable) {
					positions = positions.filter((position) => {
						return parseInt(position.available) > 0;
					});
				}

				return positions.filter((position) => {
					let searchRegex = new RegExp(self.search, 'i');

					return searchRegex.test(position.name) || searchRegex.test(position.department.name);
				});
			}
		},

		methods: {
			_m (key, attributes = '') {
				return window._m(key, attributes);
			},

			away () {
				this.show = false;
			},

			selectPosition (position) {
				this.selectedPosition = position;
				this.show = false;
				this.search = '';
			},

			showIcon (icon) {
				return window.icon(icon);
			}
		},

		created () {
			let self = this;

			if (this.selected) {
				this.selectedPosition = this.selected;
			}

			if (this.items && this.items.length > 0) {
				this.positions = this.items;
			} else {
				axios.get(route('api.positions')).then((response) => {
					self.positions = response.data;
				});
			}
		}
	};
</script>