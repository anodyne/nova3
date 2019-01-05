<template>
    <component :is="icon" class="icon"></component>
</template>

<script>
import kebab from 'lodash/kebabcase';
import * as icons from 'vue-feather-icons';

export default {
    name: 'IconFeather',

    components: {
        ...icons
    },

    props: {
        name: {
            type: String,
            required: true
        }
    },

    computed: {
        icon () {
            return kebab(this.name) + '-icon';
        }
    }
};
</script>