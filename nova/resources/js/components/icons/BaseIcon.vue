<script>
import find from 'lodash/find';

export default {
    name: 'BaseIcon',

    props: {
        name: {
            type: String,
            required: true
        }
    },

    data () {
        return {
            icon: this.name
        };
    },

    computed: {
        iconClasses () {
            return {
                icon: true
            };
        },

        iconName () {
            const name = find(Nova.config.icons, (icon, key) => {
                return key === this.icon;
            });

            if (name === undefined) {
                return this.icon;
            }

            return name;
        },

        tagName () {
            return 'i';
        }
    },

    render (h) {
        return h(this.tagName, {
            class: this.iconClasses
        }, this.$slots.default);
    }
};
</script>
