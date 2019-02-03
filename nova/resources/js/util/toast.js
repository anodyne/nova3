export default class Toast {
    constructor () {
        this.message = '';
        this.type = 'is-dark';
        this.position = 'is-bottom';
    }

    atBottom () {
        this.position = 'is-bottom';

        return this;
    }

    atBottomLeft () {
        this.position = 'is-bottom-left';

        return this;
    }

    atBottomRight () {
        this.position = 'is-bottom-right';

        return this;
    }

    atTop () {
        this.position = 'is-top';

        return this;
    }

    atTopLeft () {
        this.position = 'is-top-left';

        return this;
    }

    atTopRight () {
        this.position = 'is-top-right';

        return this;
    }

    toastDark () {
        this.type = 'is-dark';

        this.createToast();
    }

    toastError () {
        this.type = 'is-danger';

        this.createToast();
    }

    toastSuccess () {
        this.type = 'is-success';

        this.createToast();
    }

    withMessage (value) {
        this.message = value;

        return this;
    }

    createToast () {
        Nova.$emit('nova.notices.toast', {
            type: this.type,
            message: this.message,
            position: this.position
        });
    }
}
