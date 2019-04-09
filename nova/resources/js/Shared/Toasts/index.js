import ToastService from './ToastService';

const Plugin = {
    install (Vue) {
        const toast = new ToastService();

        /* eslint-disable */
        Vue.prototype.$toast = toast;
        /* eslint-enable */

        // Auto-install
        if (typeof window !== 'undefined' && Object.prototype.hasOwnProperty.call(window, 'Vue')) {
            window.Toast = toast;
        }
    }
};

// Auto-install
if (typeof window !== 'undefined' && Object.prototype.hasOwnProperty.call(window, 'Vue')) {
    window.Vue.use(Plugin.install);
}

export default Plugin;
