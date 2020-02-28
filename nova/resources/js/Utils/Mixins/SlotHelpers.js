export default {
    methods: {
        hasSlot (name) {
            return !!this.$scopedSlots[name];
        }
    }
};
