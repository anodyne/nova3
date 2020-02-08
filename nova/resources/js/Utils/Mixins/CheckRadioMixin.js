export default {
    props: {
        disabled: {
            type: Boolean,
            default: false
        },
        id: {
            type: String,
            default: ''
        },
        inputClass: {
            type: String,
            default: 'text-primary-500'
        },
        name: {
            type: String,
            default: ''
        },
        nativeValue: {
            type: [String, Number, Boolean, Function, Object, Array],
            required: true
        },
        value: {
            type: [String, Number, Boolean, Function, Object, Array],
            required: true
        }
    },

    data () {
        return {
            newValue: this.value
        };
    },

    computed: {
        computedValue: {
            get () {
                return this.newValue;
            },
            set (value) {
                this.newValue = value;
                this.$emit('input', value);
            }
        }
    },

    watch: {
        value (value) {
            this.newValue = value;
        }
    },

    methods: {
        focus () {
            // MacOS FireFox and Safari do not focus when clicked
            this.$refs.input.focus();
        }
    }
};
