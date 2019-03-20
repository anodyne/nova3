<script>
export default {
    name: 'FormMethod',

    props: {
        delete: {
            type: Boolean,
            default: false
        },
        get: {
            type: Boolean,
            default: false
        },
        patch: {
            type: Boolean,
            default: false
        },
        post: {
            type: Boolean,
            default: false
        },
        put: {
            type: Boolean,
            default: false
        }
    },

    computed: {
        method () {
            if (this.delete) {
                return 'DELETE';
            }

            if (this.get) {
                return 'GET';
            }

            if (this.patch) {
                return 'PATCH';
            }

            if (this.post) {
                return 'POST';
            }

            if (this.put) {
                return 'PUT';
            }
        }
    },

    render (h) {
        return h('input', {
            attrs: {
                type: 'hidden',
                name: '_method'
            },
            domProps: {
                value: this.method
            }
        });
    }
};
</script>
