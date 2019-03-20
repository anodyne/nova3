<template>
    <font-awesome-icon :icon="name" class="icon"></font-awesome-icon>
</template>

<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

export default {
    name: 'IconFontAwesome',

    components: {
        FontAwesomeIcon
    },

    props: {
        name: {
            type: String,
            required: true
        }
    }
};
</script>
