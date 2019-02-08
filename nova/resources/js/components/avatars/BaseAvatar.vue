<template>
    <div :class="avatarStyles">
        <div class="avatar-image"></div>

        <div v-if="showMeta" class="avatar-meta">
            <div class="avatar-meta-title">{{ name }}</div>

            <div v-if="size !== 'sm'" class="avatar-meta-subtitle">
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
        size: {
            type: String,
            default: 'md'
        },
        spread: {
            type: Boolean,
            default: true
        },
        stacked: {
            type: Boolean,
            default: false
        }
    },

    computed: {
        avatarStyles () {
            return {
                avatar: true,
                'avatar-spread': this.spread,
                'avatar-stacked': this.stacked,
                'avatar-sm': this.size === 'sm',
                'avatar-md': this.size === 'md' || !this.size,
                'avatar-lg': this.size === 'lg',
                'avatar-xl': this.size === 'xl'
            };
        },

        name () {
            return this.person.name;
        }
    }
};
</script>
