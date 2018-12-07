<template>
    <div/>
</template>

<script>
export default {
    props: {
        show: {
            type: String,
            default: ''
        }
    },

    created () {
        const escapeHandler = (e) => {
            if (e.key === 'Escape' && this.show) {
                this.dismiss();
            }
        };

        document.addEventListener('keydown', escapeHandler);

        this.$once('hook:destroyed', () => {
            document.removeEventListener('keydown', escapeHandler);
        });
    },

    methods: {
        dismiss () {
            this.$emit('close');
        }
    }
};
</script>
