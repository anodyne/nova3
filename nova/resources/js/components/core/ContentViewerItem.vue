<template>
	<div v-show="active">
		<slot></slot>
	</div>
</template>

<script>
export default {
	inject: ['contentViewerState'],

	props: {
		itemId: {
			type: String,
			required: true
		},

		title: {
			type: String,
			required: true
		}
	},

	computed: {
		active () {
			return this.contentViewerState.activeItem === this.itemId;
		}
	},

	methods: {
		toggle () {
			this.contentViewerState.activeItem = this.active
				? this.contentViewerState.activeItem
				: this.itemId;
		}
	}
};
</script>
