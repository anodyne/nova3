<script>
export default {
    name: 'CsrfToken',

    render (h) {
        return h('input', {
            attrs: {
                type: 'hidden',
                name: '_token'
            },
            domProps: {
                value: document.head.querySelector('meta[name="csrf-token"]').content
            }
        });
    }
};
</script>
