<template>
	<div class="accordion-list">
		<slot></slot>
	</div>
</template>

<script>
export default {
	provide () {
		return {
			accordionListState: this.sharedState
		}
	},

	data () {
		return {
			sharedState: {
				activeItem: 1
			}
		}
	}
};
</script>
