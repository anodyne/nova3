export default class Toast {
    constructor () {
        this.actionText = '';
        this.actionFunction = null;
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

    error () {
        this.type = 'is-danger';

        this.createToast();
    }

    success () {
        this.type = 'is-success';

        this.createToast();
    }

    withAction (callback) {
        this.actionFunction = callback;

        return this;
    }

    withActionText (value) {
        this.actionText = value;

        return this;
    }

    withMessage (value) {
        this.message = value;

        return this;
    }

    make () {
        Nova.$emit('nova.alert', {
            actionText: this.actionText,
            actionFunction: this.actionFunction,
            type: this.type,
            message: this.message,
            position: this.position
        });
    }
}
