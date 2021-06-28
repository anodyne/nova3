export default (options = {}) => ({
    open: false,
    value: 0,
    selected: 0,
    activeDescendant: 'listbox-option-0',
    ...options,

    onButtonClick() {
        this.open = !this.open;
        this.$refs.listbox.focus();
    },

    onEscape() {
        this.open = false;
    },

    onOptionSelect() { },

    onArrowUp() {
        this.selected -= 1;
    },

    onArrowDown() {
        this.selected += 1;
    },

    choose(value) {
        this.value = value;
        this.selected = value;
        this.open = false;
    },
});
