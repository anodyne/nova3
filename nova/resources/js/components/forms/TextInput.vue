<template>
	<div :class="wrapperClasses">
		<label class="field-label" v-text="label" v-if="label"></label>

		<div :class="groupClasses">
			<input class="field"
				   :type="type"
				   :name="name"
				   :placeholder="placeholder"
				   v-model="fieldValue"
				   @input="$emit('input', fieldValue)">

			<div class="addon-before" v-if="hasAddonBefore">
				<slot name="field-addon-before"></slot>
			</div>
			<div class="addon-after" v-if="hasAddonAfter">
				<slot name="field-addon-after"></slot>
			</div>
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
			type: { type: String, default: 'text' },
			value: {},
		},

		data () {
			return {
				fieldValue: this.value
			}
		},

		computed: {
			groupClasses () {
				let pieces = ['field-group']

				if (this.hasAddonBefore) {
					pieces.push('has-addon-before')
				}

				if (this.hasAddonAfter) {
					pieces.push('has-addon-after')
				}

				return pieces
			},

			hasAddonAfter () {
				return !!this.$slots['field-addon-after']
			},

			hasAddonBefore () {
				return !!this.$slots['field-addon-before']
			},

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
