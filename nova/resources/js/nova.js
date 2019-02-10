import Vue from 'vue';
import axios from '@/util/axios';
import Alert from '@/util/alert';
import FormErrors from './util/form-errors';

export default class Nova {
    constructor () {
        this.bus = new Vue();
        this.bootingCallbacks = [];
        this.config = {};
        this.data = {};
        this.formErrors = {};
        this.mixin = {};
    }

    alert () {
        return new Alert();
    }

    booting (callback) {
        this.bootingCallbacks.push(callback);
    }

    boot () {
        this.bootingCallbacks.forEach((callback) => {
            return callback(Vue);
        });

        this.bootingCallbacks = [];
    }

    extend (mixin) {
        this.mixin = mixin;
    }

    run () {
        this.boot();

        this.app = new Vue({
            el: '#nova-app',

            mixins: [this.mixin]
        });
    }

    request (options) {
        if (options !== undefined) {
            return axios(options);
        }

        return axios;
    }

    extendConfig (config) {
        this.config = {
            ...config,
            ...this.config
        };
    }

    setConfig (config) {
        this.config = {
            ...this.config,
            ...config
        };

        this.data = config.response;
    }

    setFormErrors (errors) {
        this.formErrors = new FormErrors(errors);
    }

    $on (...args) {
        this.bus.$on(...args);
    }

    $once (...args) {
        this.bus.$once(...args);
    }

    $off (...args) {
        this.bus.$off(...args);
    }

    $emit (...args) {
        this.bus.$emit(...args);
    }
}
