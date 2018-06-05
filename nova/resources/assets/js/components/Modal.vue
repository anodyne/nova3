<template>
	<div></div>
</template>

<script>
export default {
	props: ['show'],

	methods: {
		dismiss () {
			this.$emit('close')
		}
	},

	created () {
		const escapeHandler = (e) => {
			if (e.key == 'Escape' && this.show) {
				this.dismiss()
			}
		}

		document.addEventListener('keydown', escapeHandler)

		this.$once('hook:destroyed', () => {
			document.removeEventListener('keydown', escapeHandler)
		})
	},
}
</script>
