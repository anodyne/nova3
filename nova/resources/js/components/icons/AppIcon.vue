<template>
    <component :is="component" :name="icon"></component>
</template>

<script>
import find from 'lodash/find';

export default {
    name: 'AppIcon',

    props: {
        name: {
            type: String,
            required: true
        }
    },

    computed: {
        component () {
            switch (Nova.config.theme.iconSet) {
                case 'feather':
                    return 'IconFeather';
                    break;

                case 'fa5':
                    return 'IconFontAwesome';
                    break;
            }
        },

        icon () {
            const name = find(Nova.config.icons, (icon, key) => {
                return key === this.name;
            });

            if (name === undefined) {
                return this.name;
            }

            return name;
        },
    }
};
</script>