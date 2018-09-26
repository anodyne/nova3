export default {
    render (h) {
        return h('div', {
            attrs: {
                class: 'hidden lg:block'
            }
        }, this.$slots.default);
    }
};
