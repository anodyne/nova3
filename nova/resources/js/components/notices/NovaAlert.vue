<template>
    <transition :enter-active-class="transition.enter" :leave-active-class="transition.leave">
        <div
            v-show="isActive"
            class="alert"
            :class="[type, position]"
            :role="role"
            :aria-live="ariaLive"
            aria-atomic="true"
        >
            <p class="message">{{ message }}</p>

            <div v-if="isActionable" class="action">
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

export default {
    name: 'NovaAlert',

    props: {
        data: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            actionFunction: null,
            actionText: '',
            isActive: false,
            message: '',
            position: 'is-bottom-right',
            type: 'is-dark'
        };
    },

    computed: {
        ariaLive () {
            if (this.isError) {
                return 'assertive';
            }

            return 'polite';
        },

        duration () {
            if (this.isActionable) {
                return 6000;
            }

            return 3000;
        },

        isActionable () {
            return this.actionText !== '';
        },

        isError () {
            return this.type.includes('danger');
        },

        role () {
            if (this.isError) {
                return 'alert';
            }

            return 'status';
        },

        shouldShow () {
            return this.message !== '';
        },

        transition () {
            switch (this.position) {
                case 'is-bottom':
                default:
                    return {
                        enter: 'animated faster fadeInUp',
                        leave: 'animated faster fadeOutDown'
                    };

                case 'is-top':
                    return {
                        enter: 'animated faster fadeInDown',
                        leave: 'animated faster fadeOutUp'
                    };

                case 'is-bottom-right':
                case 'is-top-right':
                    return {
                        enter: 'animated faster fadeInRight',
                        leave: 'animated faster fadeOutRight'
                    };

                case 'is-bottom-left':
                case 'is-top-left':
                    return {
                        enter: 'animated faster fadeInLeft',
                        leave: 'animated faster fadeOutLeft'
                    };
            }
        }
    },

    mounted () {
        this.setData();

        if (this.shouldShow) {
            this.show();
        }
    },

    methods: {
        action () {
            if (this.actionFunction !== null) {
                this.actionFunction();
            } else {
                this.close();
            }
        },

        close () {
            if (!this.isActive) {
                return;
            }

            clearTimeout(this.timer);
            this.isActive = false;
        },

        setData () {
            this.message = has(this.data, 'message') ? this.data.message : '';
            this.position = has(this.data, 'position') ? this.data.position : 'is-bottom-right';
            this.type = has(this.data, 'type') ? this.data.type : 'is-dark';
            this.actionText = has(this.data, 'actionText') ? this.data.actionText : '';
            this.actionFunction = has(this.data, 'actionFunction') ? this.data.actionFunction : null;
        },

        show () {
            this.isActive = true;

            this.timer = setTimeout(() => {
                this.close();
            }, this.duration);
        }
    }
};
</script>
