<template>
	<div class="flex flex-col">
		<div class="flex w-full border-b">
			<div class="p-3" v-for="(item, index) in items" :key="index" role="presentation">
				<a role="button" @click="item.toggle">
					{{ item.title }}
				</a>
			</div>
		</div>

		<div>
			<slot></slot>
		</div>
	</div>
</template>

<script>
export default {
	provide () {
		return {
			contentViewerState: this.sharedState
		}
	},

	data () {
		return {
			items: [],
			sharedState: {
				activeItem: '1',
			}
		}
	},

	created () {
		this.items = this.$children;
	}
};
</script>
