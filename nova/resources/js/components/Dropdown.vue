<template>
	<div :class="dropdownClasses">
		<div class="dropdown-trigger">
			<button type="button"
					:class="buttonClasses"
					data-toggle="dropdown"
					aria-haspopup="true"
					aria-expanded="false"
			>
				<slot name="trigger-simple"></slot>

				<span v-if="hasSlot('trigger')">
					<slot name="trigger"></slot>
				</span>
				<icon name="chevron-down" class="dropdown-caret" v-if="hasSlot('trigger')"></icon>
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
import slots from '../mixins/slots'

export default {
	props: {
		direction: { type: String, default: '' },
		inverted: { type: Boolean, default: true },
	},

	mixins: [slots],

	computed: {
		buttonClasses () {
			return [
				'button',
				this.hasSlot('trigger-simple') ? 'is-flush' : ''
			]
		},

		dropdownClasses () {
			return [
				'dropdown',
				this.direction != '' ? 'is-' + this.direction : '',
				this.inverted ? 'is-inverted' : '',
			]
		}
	}
}
</script>
