import Vue from 'vue';

export default class AlertService {
    constructor () {
        this.actionText = '';
        this.actionFunction = null;
        this.message = '';
        this.type = '';
        this.emitter = new Vue();
    }

    make () {
        this.createAlert();
    }

    error () {
        this.type = 'is-danger';

        this.createAlert();
    }

    success () {
        this.type = 'is-success';

        this.createAlert();
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

    createAlert () {
        this.emitter.$emit('nova.alert', {
            actionText: this.actionText,
            actionFunction: this.actionFunction,
            type: this.type,
            message: this.message
        });
    }
}
