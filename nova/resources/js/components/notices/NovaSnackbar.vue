<template>
    <transition :enter-active-class="transition.enter" :leave-active-class="transition.leave">
        <div
            v-show="isActive"
            class="snackbar"
            :class="[type, position]"
        >
            <p class="message">{{ message }}</p>

            <div v-if="actionText" class="action">
                <button
                    class="button"
                    :class="type"
                    @click="action"
                >
                    {{ actionText }}
                </button>
            </div>
        </div>
    </transition>
</template>

<script>
import has from 'lodash/has';
import NoticesHelpers from '@/mixins/NoticesHelpers';

export default {
    name: 'NovaSnackbar',

    mixins: [NoticesHelpers],

    data () {
        return {
            actionText: 'OK',
            actionFunction: null
        };
    },

    mounted () {
        Nova.$on('nova.notices.snackbar', (params) => {
            this.setData(params);
            this.show();
        });
    },

    methods: {
        action () {
            if (this.actionFunction) {
                this.actionFunction();
            } else {
                this.close();
            }
        },

        setData (data) {
            this.message = has(data, 'message') ? data.message : '';
            this.position = has(data, 'position') ? data.position : 'is-bottom';
            this.type = has(data, 'type') ? data.type : 'is-dark';
            this.actionText = has(data, 'actionText') ? data.actionText : 'OK';
            this.actionFunction = has(data, 'actionFunction') ? data.actionFunction : null;
        },

        show () {
            this.isActive = true;
        }
    }
};
</script>
