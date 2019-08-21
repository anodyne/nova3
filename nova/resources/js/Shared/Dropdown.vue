<template>
    <div
        v-click-outside="close"
        class="dropdown"
        :class="{ 'is-active': isOpen }"
        @keydown.escape.prevent="close"
    >
        <button
            ref="trigger"
            type="button"
            class="dropdown-trigger"
            @click="toggle"
        >
            <slot></slot>
        </button>

        <transition
            enter-class="opacity-0 scale-75"
            enter-active-class="ease-out"
            enter-to-class="opacity-100 scale-100"
            leave-class="opacity-100 scale-100"
            leave-active-class="ease-in"
            leave-to-class="opacity-0 scale-75"
        >
            <div
                v-show="isOpen"
                ref="dropdown"
                class="dropdown-menu"
            >
                <slot name="dropdown" :dropdownProps="dropdownProps"></slot>
            </div>
        </transition>
    </div>
</template>

<script>
import Popper from 'popper.js';

export default {
    name: 'Dropdown',

    props: {
        boundary: {
            type: String,
            default: 'scrollParent'
        },
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

    computed: {
        dropdownProps () {
            return {
                toggle: this.toggle
            };
        }
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
                        boundariesElement: this.boundary
                    },
                    preventOverflow: {
                        boundariesElement: this.boundary
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
