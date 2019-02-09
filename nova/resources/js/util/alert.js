export default class Alert {
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

    dark () {
        this.type = 'is-dark';

        this.make();
    }

    error () {
        this.type = 'is-danger';

        this.make();
    }

    success () {
        this.type = 'is-success';

        this.make();
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
