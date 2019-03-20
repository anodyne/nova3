<template>
    <div
        v-click-outside="close"
        class="dropdown"
        :class="{ 'is-active': isOpen }"
        @keydown.escape.prevent="close"
    >
        <div ref="trigger">
            <slot name="trigger" :trigger-function="open"></slot>
        </div>

        <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
            <div
                v-show="isOpen"
                ref="dropdown"
                class="dropdown"
            >
                <slot></slot>
            </div>
        </transition>
    </div>
</template>

<script>
import Popper from 'popper.js';

export default {
    name: 'BaseDropdown',

    props: {
        placement: {
            type: String,
            default: 'bottom-start'
        }
    },

    data () {
        return {
            isOpen: false
        };
    },

    beforeDestroy () {
        if (!this.popper) {
            return;
        }

        this.popper.destroy();
    },

    methods: {
        close () {
            if (this.isOpen) {
                this.isOpen = false;
            }
        },

        initializePopper () {
            if (this.popper) {
                return;
            }

            this.popper = new Popper(this.$refs.trigger, this.$refs.dropdown, {
                positionFixed: true,
                placement: this.placement,
                modifiers: {
                    flip: {
                        boundariesElement: 'viewport'
                    },
                    preventOverflow: {
                        boundariesElement: 'viewport'
                    }
                }
            });
        },

        open () {
            this.isOpen = true;

            this.$nextTick(() => {
                this.initializePopper();

                if (this.popper) {
                    this.popper.scheduleUpdate();
                }
            });
        },

        toggle () {
            if (this.isOpen) {
                this.close();
            } else {
                this.open();
            }
        }
    }
};
</script>
