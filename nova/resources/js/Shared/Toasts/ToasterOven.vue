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
import Toast from './Toast.vue';

export default {
    name: 'ToasterOven',

    components: { Toast },

    data () {
        return {
            toasts: []
        };
    },

    watch: {
        '$page.toast': function () {
            if (this.$page.toast.message) {
                this.toasts.push(this.$page.toast);
            }
        }
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
