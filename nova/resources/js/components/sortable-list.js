import Sortable from 'sortablejs';

export default () => ({
    newSortOrder: '',
    sortable: null,

    init() {
        const el = document.getElementById('sortable-list');

        this.sortable = Sortable.create(el, {
            draggable: '.sortable-item',
            handle: '.sortable-handle',
            onEnd: () => {
                this.newSortOrder = this.sortable.toArray();
            },
        });
    },
});
