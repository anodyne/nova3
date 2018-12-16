<template>
    <div class="icon-wrapper" v-html="renderIcon()"></div>
</template>

<script>
import forEach from 'lodash/forEach';
import mergeWith from 'lodash/mergeWith';

export default {
    props: {
        name: {
            type: String,
            required: true
        },
        size: {
            type: String,
            default: ''
        },
        attributes: {
            type: Object,
            default: () => { return {}; }
        },
        iconClass: {
            type: String,
            default: ''
        }
    },

    methods: {
        renderIcon () {
            const iconTemplate = Nova.config.iconTemplate.replace(/{icon}/g, Nova.config.icons[this.name]);

            const parser = new DOMParser();

            const icon = parser.parseFromString(iconTemplate, 'text/html').body.firstChild;

            const attributes = {};

            forEach(icon.attributes, (attr) => {
                attributes[attr.nodeName] = attr.nodeValue;
            });

            // if (this.size) {
            //     attributes.class = `is-${this.size} ${attributes.class}`;
            // }

            if (this.iconClass) {
                attributes.class = `${this.iconClass} ${attributes.class}`;
            }

            // if (this.attributes) {
            //     attributes = {
            //         ...this.attributes,
            //         ...attributes
            //     };
            // }

            forEach(attributes, (value, name) => {
                icon.setAttribute(name, value);
            });

            return icon.outerHTML;
        }
    }
};
</script>
