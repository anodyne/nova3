<template>
    <div class="avatar" :class="styles.size">
        <img
            v-if="url !== ''"
            :src="url"
            alt="avatar image"
            class="avatar-image"
        >
        <div
            v-if="url === ''"
            class="avatar-title"
            :class="styles.title"
            v-text="title"
        ></div>
    </div>
</template>

<script>
export default {
    name: 'Avatar',

    props: {
        size: {
            type: String,
            default: ''
        },
        title: {
            type: String,
            default: ''
        },
        url: {
            type: String,
            default: ''
        }
    },

    computed: {
        styles () {
            return {
                size: {
                    [`avatar-${this.size}`]: this.size !== ''
                },
                title: {
                    'avatar-title-soft': this.title.charAt(0) === '+'
                }
            };
        }
    }
};
</script>
