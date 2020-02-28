<template>
    <img
        :src="imageUrl"
        class="inline-block relative rounded-full"
        :class="styles.size"
        :alt="tooltip"
    >
</template>

<script>
export default {
    name: 'Avatar',

    props: {
        imageUrl: {
            type: String,
            default: null
        },
        size: {
            type: String,
            default: 'md'
        },
        tooltip: {
            type: String,
            default: null
        }
    },

    computed: {
        avatarSizes () {
            return {
                xs: 'h-8 w-8',
                sm: 'h-10 w-10',
                md: 'h-12 w-12',
                lg: 'h-14 w-14'
            };
        },

        styles () {
            return {
                size: this.avatarSizes[this.size]
            };
        }
    }
};
</script>
