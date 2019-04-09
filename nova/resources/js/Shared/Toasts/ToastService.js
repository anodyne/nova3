import Vue from 'vue';

export default class ToastService {
    constructor () {
        this.reset();

        this.emitter = new Vue();
    }

    make () {
        this.createAlert();
    }

    error () {
        this.data.type = 'is-danger';

        this.createAlert();
    }

    success () {
        this.data.type = 'is-success';

        this.createAlert();
    }

    action (callback) {
        this.data.actionFunction = callback;

        return this;
    }

    actionText (value) {
        this.data.actionText = value;

        return this;
    }

    message (value) {
        this.data.message = value;

        return this;
    }

    reset () {
        this.data = {
            type: '',
            message: '',
            actionText: '',
            actionFunction: null
        };
    }

    createAlert () {
        this.emitter.$emit('nova.toast', this.data);

        this.reset();
    }
}
