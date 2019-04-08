import AlertService from './AlertService';

const Plugin = {
    install (Vue) {
        const alert = new AlertService();

        /* eslint-disable */
        Vue.prototype.$alert = alert;
        /* eslint-enable */

        // auto install
        if (typeof window !== 'undefined' && Object.prototype.hasOwnProperty.call(window, 'Vue')) {
            window.Alert = alert;
        }
    }
};

// auto install
if (typeof window !== 'undefined' && Object.prototype.hasOwnProperty.call(window, 'Vue')) {
    window.Vue.use(Plugin.install);
}

export default Plugin;
