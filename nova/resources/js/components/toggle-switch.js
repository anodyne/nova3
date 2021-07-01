export default (on, disabled = false) => ({
    on,
    disabled,

    toggle() {
        if (!this.disabled) {
            this.on = !this.on;
            this.$dispatch('toggle-changed', { value: Boolean(this.on) });
            this.$dispatch('input', Boolean(this.on));
        }
    },
});
