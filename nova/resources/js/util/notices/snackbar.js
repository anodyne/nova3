export default class Snackbar {
    constructor () {
        this.message = '';
        this.type = 'is-dark';
        this.position = 'is-bottom';
        this.actionText = 'OK';
        this.actionFunction = null;
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

    snackbarDark () {
        this.type = 'is-dark';

        this.createSnackbar();
    }

    snackbarError () {
        this.type = 'is-danger';

        this.createSnackbar();
    }

    snackbarSuccess () {
        this.type = 'is-success';

        this.createSnackbar();
    }

    withAction (value) {
        this.actionFunction = value;

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

    createSnackbar () {
        Nova.$emit('nova.notices.snackbar', {
            type: this.type,
            message: this.message,
            position: this.position,
            actionText: this.actionText,
            actionFunction: this.actionFunction
        });
    }
}
