export default (tab) => ({
    tab,

    switchTab(newTab) {
        this.tab = newTab;
        window.history.pushState({ tab: this.tab }, null, newTab);
    },
});
