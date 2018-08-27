<template>
	<div :class="wrapperClasses">
		<label class="field-label" v-text="label" v-if="label"></label>

		<div class="field-group">
			<textarea class="field"
					  :name="name"
					  :placeholder="placeholder"
					  v-model="fieldValue"
					  @input="$emit('input', fieldValue)">
			</textarea>
		</div>

		<div class="field-help" v-text="help"></div>

		<div class="field-help field-error" v-text="error" v-if="hasError"></div>
	</div>
</template>

<script>
	export default {
		props: {
			error: { type: String },
			help: { type: String },
			label: { type: String },
			name: { type: String },
			placeholder: { type: String },
			value: {},
		},

		data () {
			return {
				fieldValue: this.value
			}
		},

		computed: {
			hasError () {
				return this.error && this.errors != ''
			},

			wrapperClasses () {
				let pieces = ['field-wrapper']

				if (this.hasErrors) {
					pieces.push('has-error')
				}

				return pieces
			}
		},

		watch: {
			value (newValue) {
				this.fieldValue = newValue
			}
		}
	}
</script>
