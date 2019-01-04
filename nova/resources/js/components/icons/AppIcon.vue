<template>
    <component :is="component" :name="icon"></component>
</template>

<script>
import IconFeather from './IconFeather.vue';
import IconFontAwesome from './IconFontAwesome.vue';

export default {
    name: 'AppIcon',

    props: {
        name: {
            type: String,
            required: true
        }
    },

    data () {
        return {
            icon: this.name
        }
    },

    computed: {
        component () {
            switch (Nova.config.theme.iconSet) {
                case 'feather':
                    return IconFeather;
                    break;

                case 'fa5':
                    return IconFontAwesome;
                    break;
            }
        }
    }
};
</script>