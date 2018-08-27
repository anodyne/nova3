<template>
	<span :class="wrapperClasses" role="checkbox" tabindex="0"
		  :aria-checked="value.toString()"
		  @click="toggle"
		  @keydown.space.prevent="toggle"
	>
		<span :class="backgroundClasses"></span>
		<span :class="indicatorClasses"></span>

		<input type="checkbox" class="hidden" :name="name" :value="value">
	</span>
</template>

<script>
export default {
	props: {
		name: { type: String, required: true },
		small: { type: Boolean, default: false },
		large: { type: Boolean, default: false },
		value: { required: true }
	},

	computed: {
		backgroundClasses () {
			let classes = ['switch-background']

			if (this.isChecked) {
				classes.push('active')
			}

			return classes
		},

		indicatorClasses () {
			let classes = ['switch-indicator']

			if (this.isChecked) {
				classes.push('active')
			}

			return classes
		},

		isChecked () {
			if (typeof(this.value) == typeof(true)) {
				return this.value
			}

			return this.value == "true"
		},

		wrapperClasses () {
			let classes = ['switch-wrapper']

			if (this.large) {
				classes.push('is-large')
			}

			if (this.small) {
				classes.push('is-small')
			}

			return classes
		}
	},

	methods: {
		toggle () {
			this.$emit('input', !this.isChecked)
		}
	}
}
</script>
