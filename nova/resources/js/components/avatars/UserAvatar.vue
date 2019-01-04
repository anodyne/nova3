<script>
import BaseAvatar from './BaseAvatar.vue';

export default {
    name: 'UserAvatar',

    extends: BaseAvatar,

    props: {
        user: {
            type: Object,
            required: true
        }
    },

    computed: {
        baseProps () {
            return {
                person: this.user,
                spread: this.spread,
                stacked: this.stacked,
                size: this.size,
                showMeta: this.showMeta
            };
        }
    },

    render (h) {
        return h('base-avatar', {
            props: this.baseProps
        }, this.$slots.default)
    }
};
</script>
