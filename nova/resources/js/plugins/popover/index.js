import Popover from './Popover.vue';

const prepareBinding = ({ arg = '', modifiers = {}, value = {} }) => {
    const name = typeof value === 'object' && value.name ? value.name : arg;

    return { name, value };
};

export default {
    install (Vue) {
        Vue.component('nova-popover', Popover);

        Vue.directive('popover', {
            bind (target, binding) {
                const params = prepareBinding(binding);

                console.log('v-popover bind');
                console.log('v-popover target', target);
                console.log('v-popover bindings', binding);
                console.log('v-popover params', params);
                // const params = prepareBinding(binding);

                // addClickEventListener(target, params);
            }
        });
    }
};
