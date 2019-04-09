<template>
    <div class="toasts" aria-atomic="true">
        <toast
            v-for="(toast, index) in toasts"
            :key="index"
            :data="toast"
            @toast-hidden="remove(index)"
        ></toast>
    </div>
</template>

<script>
import has from 'lodash/has';
import isArray from 'lodash/isArray';
import Toast from './Toast';

export default {
    name: 'ToastsManager',

    components: { Toast },

    data () {
        return {
            toasts: []
        };
    },

    mounted () {
        if (novaToast) {
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
            }, 2000);
        },

        setData (data) {
            this.toasts.push({
                message: has(data, 'message') ? data.message : '',
                type: has(data, 'type') ? data.type : '',
                actionFunction: has(data, 'actionFunction') ? data.actionFunction : null,
                actionText: has(data, 'actionText') ? data.actionText : ''
            });
        }
    }
};
</script>
