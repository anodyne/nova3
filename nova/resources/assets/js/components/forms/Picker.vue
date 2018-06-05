<template>
	<div class="item-picker">
		<div class="item-picker-selector">
			<div role="button" class="item-picker-toggle" @click.prevent="show = !show" v-if="selectedItem">
				<div class="item-picker-selected">
					<div class="spread" v-if="selectedItem">
						<slot name="picker-selected-item" :item="selectedItem"></slot>
					</div>
					<div v-else>
						<slot name="picker-nothing-selected"></slot>
					</div>
					<div class="ml-3 leading-0">
						<icon name="chevron-down" size="small" />
					</div>
				</div>

				<slot name="picker-field" :item="selectedItem"></slot>
			</div>

			<slot></slot>
		</div>

		<div v-show="show" class="items-menu">
			<div class="search-group">
				<span class="search-field">
					<icon name="search"/>
					<input type="text" placeholder="Find..." v-model="search">
				</span>
				<a href="#" class="clear-search ml-2 leading-0" @click.prevent="search = ''">
					<icon name="close-alt" />
				</a>
			</div>

			<div class="items-menu-alert" v-show="filteredItems.length == 0">
				<div class="alert alert-warning">
					<slot name="picker-list-empty-message"></slot>
				</div>
			</div>

			<!--<div class="items-menu-item" v-if="selectedItem != false" @click.prevent="select(false)">
				<rank></rank>
				<small class="meta" v-text="lang('genre-ranks-none')"></small>
			</div>-->

			<div class="items-menu-item" v-for="item in filteredItems" :key="item.id" @click.prevent="select(item)">
				<slot name="picker-list-item" :item="item"></slot>
			</div>
		</div>
	</div>
</template>

<script>
import Icon from '../Icon.vue'

export default {
	props: ['items', 'selected'],

	components: { Icon },

	data () {
		return {
			search: '',
			selectedItem: this.selected,
			show: false
		}
	},

	computed: {
		filteredItems () {
			return this.items
			return this.items.filter((item) => {
				let searchRegex = new RegExp(this.search, 'i')

				// TODO: Need a better way to handle which items we're potentially searching by
				// return searchRegex.test(item.info.name) || searchRegex.test(item.group.name)
			})
		}
	},

	methods: {
		reset () {
			this.search = ''
			this.show = false
		},

		select (item) {
			this.selectedItem = item
			this.reset()

			// TODO: Need a better way to handle emitting a selected event and the different data we may need to emit
			this.$events.$emit('picker-item-selected', this.selectedItem)
		}
	}
}
</script>
