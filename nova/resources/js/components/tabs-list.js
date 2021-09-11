export default (tab, withHistory = false) => ({
    tab,
    withHistory,

    isNotTab(tabToCheck) {
        return tabToCheck !== this.tab;
    },

    isTab(tabToCheck) {
        return tabToCheck === this.tab;
    },

    switchTab(newTab) {
        this.tab = newTab;

        if (this.withHistory) {
            window.history.pushState({ tab: this.tab }, null, newTab);
        }
    },
});
