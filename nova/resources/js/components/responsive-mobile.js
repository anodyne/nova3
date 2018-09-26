export default {
    render (h) {
        return h('div', {
            attrs: {
                class: 'block md:hidden'
            }
        }, this.$slots.default);
    }
};
