<script>
import _ from 'lodash';

export default {
	props: {
		iconAttrs: {
			type: Object,
			default: () => {
				return {};
			}
		},
		iconClass: {
			type: String,
			default: ''
		},
		name: {
			type: String,
			default: '',
			required: true
		},
		wrapperAttrs: {
			type: Object,
			default: () => {
				return {};
			}
		},
		wrapperClass: {
			type: String,
			default: ''
		},
		wrapperElement: {
			type: String,
			default: 'div'
		}
	},

	computed: {
		icon () {
			return Nova.config.icons[this.name];
		},

		parsedTemplate () {
			return Nova.config.iconTemplate.replace(/{icon}/g, this.icon);
		}
	},

	methods: {
		getIconAttributes (icon) {
			let attributes = {};

			_.forEach(icon.attributes, (attr) => {
				attributes[attr.nodeName] = attr.nodeValue;
			});

			attributes['class'] = [attributes['class'], this.iconClass].join(' ');

			return attributes;
		},

		getParsedIcon () {
			const parser = new DOMParser();

			return parser.parseFromString(this.parsedTemplate, 'text/html').body.firstElementChild;
		}
	},

	render (createElement) {
		const parsedIcon = this.getParsedIcon();

		const icon = createElement(parsedIcon.tagName, {
			attrs: this.getIconAttributes(parsedIcon)
		}, [parsedIcon.innerHTML]);

		return createElement(this.wrapperElement, {
			class: ['icon-wrapper', this.wrapperClass],
			attrs: this.wrapperAttrs
		}, [icon]);
	}
};
</script>
