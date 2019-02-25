<template>
    <component :is="component" :name="icon"></component>
</template>

<script>
import find from 'lodash/find';

export default {
    name: 'NovaIcon',

    props: {
        name: {
            type: String,
            required: true
        }
    },

    computed: {
        component () {
            switch (this.$store.get('Theme/iconSet')) {
                case 'feather':
                default:
                    return 'IconFeather';

                case 'fa5':
                    return 'IconFontAwesome';
            }
        },

        icon () {
            const name = find(this.$store.get('Icons'), (icon, key) => {
                return key === this.name;
            });

            if (name === undefined) {
                return this.name;
            }

            return name;
        }
    }
};
</script>
