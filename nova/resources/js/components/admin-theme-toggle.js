export default (appearance) => ({
    appearance,

    init() {
        this.update(this.appearance);
    },

    isDarkTheme() {
        return localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
    },

    isDarkThemeSelected() {
        return localStorage.theme === 'dark';
    },

    isLightTheme() {
        return localStorage.theme === 'light' || (!('theme' in localStorage) && !window.matchMedia('(prefers-color-scheme: dark)').matches);
    },

    isLightThemeSelected() {
        return localStorage.theme === 'light';
    },

    isSystemThemeSelected() {
        return !('theme' in localStorage);
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

        this.$wire.toggle(theme);

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
