export default {
    props: {
        value: {
            type: Boolean,
            default: false
        }
    },

    data () {
        return {
            isActive: !!this.value
        };
    },

    watch: {
        isActive (val) {
            if (!!val !== this.value) {
                this.$emit('input', val);
            }
        },

        value (val) {
            this.isActive = !!val;
        }
    }
};
