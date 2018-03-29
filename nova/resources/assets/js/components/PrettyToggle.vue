<template>
	<div :class="wrapperClasses" v-cloak>
		<input type="checkbox" :name="name" :value="value" v-if="type == 'checkbox' || type == 'switch'">
		<input type="radio" :name="name" :value="value" v-if="type == 'radio'">

		<div :class="stateClasses">
			<slot name="icon"></slot>
			<slot name="label"></slot>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			type: { type: String, required: true },
			name: { type: String, required: true },
			value: { type: String, required: true }
		},

		computed: {
			stateClasses () {
				let pieces = ['state']

				if (this.type == 'switch') {
					pieces.push('p-success')
				}

				return pieces
			},

			wrapperClasses () {
				let pieces = ['pretty', 'p-smooth']

				if (this.type == 'checkbox') {
					pieces.push('p-default')
					pieces.push('p-curve')
					pieces.push('p-thick')
				}

				if (this.type == 'radio') {
					pieces.push('p-default')
					pieces.push('p-round')
					pieces.push('p-thick')
				}

				if (this.type == 'switch') {
					pieces.push('p-switch')
					pieces.push('p-fill')
				}

				return pieces
			}
		}
	}
</script>