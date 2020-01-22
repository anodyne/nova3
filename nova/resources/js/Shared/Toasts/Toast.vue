<template>
    <transition name="toast-animated">
        <div
            v-show="isActive"
            class="toast"
            :class="type"
            :role="role"
            :aria-live="ariaLive"
            aria-atomic="true"
            @mouseenter="pauseTimer"
            @mouseleave="unpauseTimer"
        >
            <div class="progress-bar">
                <span class="percentage" :style="{ 'width': (state.progress * 100) + '%' }"></span>
            </div>

            <div class="content">
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
        </div>
    </transition>
</template>

<script>
import has from 'lodash/has';

export default {
    name: 'Toast',

    props: {
        toast: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            actionFunction: null,
            actionText: '',
            config: {},
            isActive: false,
            message: '',
            type: '',
            state: {
                paused: false,
                progress: 0
            }
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

            return false;
        },

        ariaLive () {
            if (this.isError) {
                return 'assertive';
            }

            return 'polite';
        },

        isActionable () {
            return this.actionText !== null && this.actionText !== '';
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

        this.initToast();
    },

    methods: {
        action () {
            if (this.actionFunction !== null) {
                this.actionFunction();
            } else {
                this.remove();
            }
        },

        initToast () {
            if (this.shouldShow) {
                this.isActive = true;
                this.startTimer(0);
            }
        },

        pauseTimer () {
            this.state.paused = true;
        },

        remove () {
            if (!this.isActive) {
                return;
            }

            this.isActive = false;
            this.$emit('toast-hidden', true);
        },

        setData () {
            this.message = has(this.toast, 'message') ? this.toast.message : '';
            this.type = has(this.toast, 'type') ? this.toast.type : '';
            this.actionText = has(this.toast, 'actionText') ? this.toast.actionText : '';
            this.actionFunction = has(this.toast, 'actionFunction') ? this.toast.actionFunction : null;
            this.config = has(this.toast, 'config') ? this.toast.config : {};
        },

        startTimer (startTime = 0) {
            const start = performance.now();

            const calculate = () => {
                this.animationFrame = requestAnimationFrame((timestamp) => {
                    const runtime = timestamp + startTime - start;
                    const progress = Math.min(runtime / this.toast.config.timeout, 1);

                    if (this.state.paused) {
                        cancelAnimationFrame(this.animationFrame);
                    } else if (runtime < this.toast.config.timeout) {
                        this.state.progress = progress;
                        calculate();
                    } else {
                        this.state.progress = 1;
                        cancelAnimationFrame(this.animationFrame);
                        this.remove();
                    }
                });
            };

            calculate();
        },

        unpauseTimer () {
            if (this.toast.config.timeout) {
                this.state.paused = false;
                this.startTimer(this.toast.config.timeout * this.state.progress);
            }
        }
    }
};
</script>
