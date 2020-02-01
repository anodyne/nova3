import Vue from 'vue';

export default class ToastService {
    constructor () {
        this.resetData();

        this.emitter = Vue.prototype.$events;
    }

    config (options = {}) {
        this.data.config = {
            ...this.defaultConfig(),
            ...options
        };

        return this;
    }

    make () {
        this.makeToast();
    }

    error () {
        this.data.type = 'is-danger';
        this.data.config.timeout = 8000;

        this.makeToast();
    }

    success () {
        this.data.type = 'is-success';

        this.makeToast();
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

    resetData () {
        this.data = {
            type: '',
            message: '',
            actionText: '',
            actionFunction: null,
            config: this.defaultConfig()
        };
    }

    defaultConfig () {
        return {
            timeout: 4000
        };
    }

    makeToast () {
        this.emitter.$emit('nova.toast', this.data);

        this.resetData();
    }
}
