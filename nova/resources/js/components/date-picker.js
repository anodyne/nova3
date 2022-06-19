import Datepicker from 'flowbite-datepicker/Datepicker';

export default (element) => ({
    element,
    picker: null,

    init() {
        this.picker = new Datepicker(this.element, {
            autohide: true,
            orientation: 'bottom left',
            format: 'yyyy-mm-dd',
        });
    },
});
