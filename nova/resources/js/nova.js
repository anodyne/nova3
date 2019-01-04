import Vue from 'vue';
import axios from '@/util/axios';

export default class Nova {
    constructor () {
        this.bus = new Vue();
        this.bootingCallbacks = [];
        this.config = {};
        this.mixin = {};
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

    static request (options) {
        if (options !== undefined) {
            return axios(options);
        }

        return axios;
    }

    setConfig (config) {
        this.config = config;
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