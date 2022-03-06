export default () => ({
    filtersPanelOpen: false,

    panel: {
        'x-show': function () {
            return this.filtersPanelOpen;
        },
        'x-collapse': function () {
            return true;
        },
    },

    parent: {
        '@close-filters-panel.window': function () {
            this.filtersPanelOpen = false;
        },
    },

    trigger: {
        '@click': function () {
            this.filtersPanelOpen = !this.filtersPanelOpen;
        },
    },
});
