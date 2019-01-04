<template>
    <div class="avatar" :class="containerStyles">
        <div class="avatar-image"></div>

        <div class="avatar-meta" v-if="showMeta">
            <div class="avatar-meta-title">{{ name }}</div>
            <div class="avatar-meta-subtitle" v-if="size !== 'sm'">
                <slot>Position name</slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'BaseAvatar',

    props: {
        person: {
            type: Object,
            default: () => { return {}; }
        },

        showMeta: {
            type: Boolean,
            default: true
        },

        spread: {
            type: Boolean,
            default: true
        },

        size: {
            type: String,
            default: 'md'
        },

        stacked: {
            type: Boolean,
            default: false
        }
    },

    computed: {
        containerStyles () {
            return {
                'avatar-spread': this.spread,
                'avatar-stacked': this.stacked,
                'avatar-sm': this.size === 'sm',
                'avatar-md': this.size === 'md' || !this.size,
                'avatar-lg': this.size === 'lg',
                'avatar-xl': this.size === 'xl',
            };
        },

        name () {
            return this.person.name;
        }
    }
};
</script>
