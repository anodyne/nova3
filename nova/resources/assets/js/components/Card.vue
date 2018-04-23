<template>
	<div :class="wrapper">
		<div class="card-media" v-if="hasSlot('card-media')">
			<slot name="card-media"></slot>
		</div>

		<div class="card-block">
			<div class="card-header" v-if="hasSlot('card-header')">
				<slot name="card-header"></slot>
			</div>

			<div class="card-title" v-if="hasSlot('card-title')">
				<slot name="card-title"></slot>
			</div>

			<div class="card-subtitle" v-if="hasSlot('card-subtitle')">
				<slot name="card-subtitle"></slot>
			</div>

			<div class="card-content" v-if="hasSlot('card-content')">
				<slot name="card-content"></slot>
			</div>
		</div>

		<div class="card-footer" v-if="hasSlot('card-footer')">
			<slot name="card-footer"></slot>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			inverted: { type: Boolean, default: false }
		},

		computed: {
			wrapper () {
				let classes = ['card']

				if (this.inverted) {
					classes.push('is-inverse')
				}

				return classes
			}
		},

		methods: {
			hasSlot (slotName) {
				return !!this.$slots[slotName]
			}
		}
	}
</script>
