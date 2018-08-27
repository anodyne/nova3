<template>
	<div :class="wrapperClass">
		<label :class="labelClass" :for="id" v-if="label" v-html="label"></label>
		<div :class="fieldGroupClass">
			<input v-bind="fieldAttributes"
				   v-if="type != 'textarea'"
				   @input="$emit('input')"
				   @change="$emit('change')">

			<textarea v-bind="fieldAttributes"
					  v-if="type == 'textarea'"
					  @input="$emit('input')"></textarea>

			<div class="addon-before" v-if="hasAddonBefore">
				<slot name="field-addon-before"></slot>
			</div>

			<div class="addon-after" v-if="hasAddonAfter">
				<slot name="field-addon-after"></slot>
			</div>
		</div>

		<div class="field-help" v-html="help"></div>

		<div class="field-error" v-if="hasError" v-html="error"></div>
	</div>
</template>

<script>
	export default {
		props: {
			id: { type: String },
			max: { type: String },
			min: { type: String },
			help: { type: String },
			name: { type: String, required: true },
			rows: { type: String, default: "0" },
			step: { type: String },
			type: { type: String, default: "text" },
			error: { type: String },
			label: { type: String },
			value: { type: String },
			disabled: { type: Boolean, default: false },
			required: { type: Boolean, default: false },
		},

		computed: {
			fieldAttributes () {
				let attrs = {}
				attr['class'] = this.fieldClass
				attr['name'] = this.name

				if (this.disabled) {
					attrs['disabled'] = true
				}

				if (this.required) {
					attrs['required'] = true
				}

				if (this.id) {
					attrs['id'] = this.id
				}

				if (this.value) {
					attrs['value'] = this.value
				}

				if (this.placeholder) {
					attrs['placeholder'] = this.placeholder
				}

				if (this.type == 'number') {
					attrs['max'] = this.max
					attrs['min'] = this.min
					attrs['step'] = this.step
				}

				if (this.type != 'textarea') {
					attrs['type'] = this.type
				}

				if (this.type == 'textarea') {
					attrs['rows'] = this.rows
				}

				return attrs
			},

			fieldClass () {
				let pieces = ['field']

				return pieces
			},

			fieldGroupClass () {
				let pieces = ['field-group']

				if (this.hasAddonAfter) {
					pieces.push('has-addon-after')
				}

				if (this.hasAddonBefore) {
					pieces.push('has-addon-before')
				}

				return pieces
			},

			hasAddonAfter () {
				return !!this.$slots['field-addon-after'] && type != 'textarea'
			},

			hasAddonBefore () {
				return !!this.$slots['field-addon-before'] && type != 'textarea'
			},

			hasError () {
				return this.error != null
			},

			labelClass () {
				let pieces = ['field-label']

				return pieces
			},

			wrapperClass () {
				let pieces = ['field-wrapper']

				if (this.hasError) {
					pieces.push('is-invalid')
				}

				return pieces
			}
		}
	}
</script>
