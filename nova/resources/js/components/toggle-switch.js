export default (value = false, disabled = false) => ({
    value,
    disabled,

    toggle() {
        if (!this.disabled) {
            this.value = !this.value;
            this.$dispatch('toggle-changed', { value: Boolean(this.value) });
            this.$dispatch('input', Boolean(this.value));

            this.$refs.toggle.focus();
        }
    },
});
