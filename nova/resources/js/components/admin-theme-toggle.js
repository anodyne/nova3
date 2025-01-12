export default (appearance) => ({
    appearance,

    init() {
        this.update(this.appearance);

        this.$watch('appearance', (value) => this.setTheme(value));
    },

    refreshTheme() {
        if (localStorage.getItem('flux.appearance') === 'dark' || (!('flux.appearance' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
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

        // if (theme === 'light' || theme === 'dark') {
        //     localStorage.setItem('flux.appearance', theme);
        // } else {
        //     localStorage.removeItem('flux.appearance');
        // }
    },
});
