<template>
    <transition name="alert-animated">
        <div
            v-show="isActive"
            class="alert"
            :class="type"
            :role="role"
            :aria-live="ariaLive"
            aria-atomic="true"
        >
            <p class="message">{{ message }}</p>

            <div v-if="isActionable" class="action">
                <a
                    v-if="actionIsUrl"
                    :href="actionFunction"
                    class="button"
                    :class="type"
                    :target="actionUrlTarget"
                >
                    {{ actionText }}
                </a>

                <button
                    v-else
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
    name: 'Alert',

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
            type: ''
        };
    },

    computed: {
        actionIsUrl () {
            return typeof this.actionFunction === 'string';
        },

        actionUrlTarget () {
            if (this.actionIsUrl) {
                if (this.actionFunction.includes(window.location.host)) {
                    return '_self';
                }

                return '_blank';
            }
        },

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
            this.$emit('alert-hidden', true);
        },

        setData () {
            this.message = has(this.data, 'message') ? this.data.message : '';
            this.type = has(this.data, 'type') ? this.data.type : '';
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
