export default (appearance) => ({
    appearance,

    init() {
        this.update(this.appearance);

        this.$watch('appearance', (value) => this.setTheme(value));
    },

    refreshTheme() {
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    },

    setTheme(theme = null) {
        this.update(theme);

        this.$wire.set('appearance', theme, true);

        this.refreshTheme();
    },

    update(theme = null) {
        this.appearance = theme;

        if (theme === 'light' || theme === 'dark') {
            localStorage.theme = theme;
        } else {
            localStorage.removeItem('theme');
        }
    },
});
