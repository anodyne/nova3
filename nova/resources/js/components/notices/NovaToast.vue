<template>
    <transition :enter-active-class="transition.enter" :leave-active-class="transition.leave">
        <div
            v-show="isActive"
            class="toast"
            :class="[type, position]"
        >
            <nova-icon v-if="type === 'is-success'" name="check-circle"></nova-icon>
            <nova-icon v-if="type === 'is-danger'" name="alert-circle"></nova-icon>

            <div v-html="message"></div>
        </div>
    </transition>
</template>

<script>
import NoticesHelpers from '@/mixins/NoticesHelpers';

export default {
    name: 'NovaToast',

    mixins: [NoticesHelpers],

    data () {
        return {
            duration: 3000
        };
    },

    mounted () {
        Nova.$on('nova.notices.toast', (params) => {
            this.setData(params);
            this.show();
        });
    },

    methods: {
        show () {
            this.isActive = true;

            this.timer = setTimeout(() => {
                return this.close();
            }, this.duration);
        }
    }
};
</script>
