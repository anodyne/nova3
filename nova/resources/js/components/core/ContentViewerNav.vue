<template>
	<div class="flex p-3 text-grey-darker" :class="activeState" @click="toggle">
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
		}
	},

	computed: {
		active () {
			return this.contentViewerState.activeItem === this.itemId;
		},

		activeState () {
			if (this.active) {
				return 'text-blue';
			}
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
