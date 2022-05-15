export default (value = false, disabled = false, activeValue, inactiveValue) => ({
    value,
    activeValue,
    inactiveValue,
    disabled,

    toggle() {
        if (!this.disabled) {
            if (this.value === this.activeValue) {
                this.value = this.inactiveValue;
            } else {
                this.value = this.activeValue;
            }

            console.log('active value', this.activeValue);
            console.log('inactive value', this.inactiveValue);

            this.$dispatch('toggle-changed', { value: Boolean(this.value) });
            this.$dispatch('input', Boolean(this.value));

            this.$refs.toggle.focus();
        }
    },
});
