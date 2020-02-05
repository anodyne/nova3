<template>
    <component :is="component" :name="icon"></component>
</template>

<script>
import find from 'lodash/find';
import IconFeather from './IconFeather';

export default {
    name: 'Icon',

    components: {
        IconFeather
    },

    props: {
        name: {
            type: String,
            required: true
        }
    },

    computed: {
        component () {
            return 'IconFeather';
        },

        icon () {
            return this.name;
            const name = find(this.$store.get('Icons'), (icon, key) => key === this.name);

            if (name === undefined) {
                return this.name;
            }

            return name;
        }
    }
};
</script>
