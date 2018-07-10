<template>
	<div :class="dropdownClasses">
		<div class="dropdown-trigger">
			<button type="button"
					class="button is-flush"
					data-toggle="dropdown"
					aria-haspopup="true"
					aria-expanded="false"
			>
				<span v-if="hasSlot('text')">
					<slot name="text"></slot>
				</span>
				<icon name="chevron-down" class="caret" v-if="caret"></icon>
			</button>
		</div>

		<div class="dropdown-menu">
			<div class="dropdown-content">
				<slot></slot>
			</div>
		</div>
	</div>
</template>

<script>
import slots from '../../mixins/slots'

export default {
	props: {
		caret: { type: Boolean, default: true },
		direction: { type: String, default: 'left' },
		inverted: { type: Boolean, default: true },
	},

	mixins: [slots],

	computed: {
		dropdownClasses () {
			return [
				'dropdown',
				this.direction == 'right' ? 'is-right' : '',
				this.inverted ? 'is-inverted' : '',
			]
		}
	},

	created () {}
}
</script>
