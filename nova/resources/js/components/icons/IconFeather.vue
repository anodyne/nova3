<script>
import feather from 'feather-icons';
import BaseIcon from './BaseIcon.vue';

export default {
    name: 'IconFeather',

    extends: BaseIcon,

    mounted () {
        feather.replace();
    },

    render (h) {
        return h(this.tagName, {
            attrs: {
                'data-feather': this.iconName
            },
            class: this.iconClasses
        }, this.$slots.default);
    }
};
</script>