<template>
    <base-avatar v-bind="avatarProps"></base-avatar>
</template>

<script>
import BaseAvatar from './BaseAvatar';
import AvatarHelpers from './AvatarHelpers';

export default {
    name: 'UserAvatar',

    components: { BaseAvatar },

    mixins: [AvatarHelpers],

    props: {
        user: {
            type: Object,
            required: true
        }
    },

    computed: {
        avatarProps () {
            return {
                person: this.user,
                showMetaTitle: this.showMetaTitle,
                showMetaSubtitle: false,
                size: this.size,
                stacked: this.stacked
            };
        }
    }
};
</script>
