<template>
    <div class="avatar" :class="additionalStyles">
        <div class="avatar-image"></div>

        <div v-if="showMeta" class="avatar-meta">
            <div v-if="showMetaTitle" class="avatar-meta-title">{{ name }}</div>

            <div v-if="showMetaSubtitle" class="avatar-meta-subtitle">
                <slot>Position name</slot>
            </div>
        </div>
    </div>
</template>

<script>
import AvatarHelpers from './AvatarHelpers';

export default {
    name: 'BaseAvatar',

    mixins: [AvatarHelpers],

    props: {
        person: {
            type: Object,
            required: true
        }
    },

    computed: {
        additionalStyles () {
            return {
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
        },

        showMeta () {
            return this.showMetaTitle || this.showMetaSubtitle;
        }
    }
};
</script>
