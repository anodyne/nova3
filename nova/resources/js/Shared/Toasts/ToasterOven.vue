<template>
    <div class="toaster-oven" aria-atomic="true">
        <toast
            v-for="(toast, index) in toasts"
            :key="index"
            :toast="toast"
            @toast-hidden="remove(index)"
        ></toast>
    </div>
</template>

<script>
import has from 'lodash/has';
import isArray from 'lodash/isArray';
import Toast from './Toast';

export default {
    name: 'ToasterOven',

    components: { Toast },

    data () {
        return {
            toasts: []
        };
    },

    mounted () {
        if (novaToast && novaToast.length > 0) {
            this.setData(novaToast);
        }

        this.$toast.emitter.$on('nova.toast', (toast) => {
            this.setData(toast);
        });
    },

    methods: {
        remove (index) {
            setTimeout(() => {
                this.toasts.splice(index, 1);
            }, 550);
        },

        setData (data) {
            this.toasts.push({
                message: has(data, 'message') ? data.message : '',
                type: has(data, 'type') ? data.type : '',
                actionFunction: has(data, 'actionFunction') ? data.actionFunction : null,
                actionText: has(data, 'actionText') ? data.actionText : '',
                config: has(data, 'config') ? data.config : {}
            });
        }
    }
};
</script>
