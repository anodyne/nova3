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
        'x-on:close-filters-panel.window': function () {
            this.filtersPanelOpen = false;
        },
    },

    trigger: {
        'x-on:click': function () {
            this.filtersPanelOpen = !this.filtersPanelOpen;
        },
    },
});
