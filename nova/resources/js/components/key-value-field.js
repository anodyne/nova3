export default (defaults = []) => ({
    items: [],
    json: '[]',

    init() {
        this.items = Array.isArray(defaults) ? defaults : [];
        this.updateJson();
    },

    add() {
        this.items.push({ key: '', value: '' });
        this.updateJson();
    },

    remove(index) {
        this.items.splice(index, 1);
        this.updateJson();
    },

    updateJson() {
        this.json = JSON.stringify(this.items);
    },
});
