<template>
	<div v-bind="wrapperAttributes" v-html="renderIcon()"></div>
</template>

<script>
	export default {
		props: {
			name: { type: String, required: true },
			size: { type: String },
			wrapper: { type: Object },
			attributes: { type: Object },
			classes: { type: String }
		},

		computed: {
			wrapperAttributes () {
				return _.mergeWith({}, this.wrapper, { class: 'icon-wrapper' }, (objValue, srcValue, key, object) => {
					if (object.hasOwnProperty(key)) {
						return object[key].concat(' ' + srcValue)
					}
				})
			}
		},

		methods: {
			renderIcon () {
				let template = Nova.iconTemplate.replace(/{icon}/g, Nova.icons[this.name])

				let parser = new DOMParser()

				let $icon = parser.parseFromString(template, 'text/html').body.firstChild

				let attributes = {}

				_.forEach($icon.attributes, a => {
					attributes[a.nodeName] = a.nodeValue
				})

				if (this.size) {
					attributes['class'] = 'is-' + this.size + ' ' + attributes['class']
				}

				if (this.classes) {
					attributes['class'] = this.classes + ' ' + attributes['class']
				}

				if (this.attributes) {
					attributes = _.mergeWith({}, this.attributes, attributes, (objValue, srcValue, key, object) => {
						if (object.hasOwnProperty(key)) {
							return object[key].concat(' ' + srcValue)
						}
					})
				}

				_.forEach(attributes, (value, name) => {
					$icon.setAttribute(name, value)
				})

				return $icon.outerHTML
			}
		}
	}
</script>