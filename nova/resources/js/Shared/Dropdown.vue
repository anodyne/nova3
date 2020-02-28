<template>
    <button
        type="button"
        class="relative transition ease-in-out duration-150"
        @click="show"
    >
        <slot></slot>

        <portal v-if="isActive" to="dropdown">
            <div class="fixed inset-0 z-999" @click="hide"></div>

            <div ref="dropdown" class="z-9999">
                <transition
                    enter-active-class="transition ease-out duration-100"
                    enter-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95"
                    appear
                >
                    <div class="absolute mt-2 w-56 rounded-md shadow-lg" :class="styles.placement">
                        <div class="rounded-md bg-white shadow-xs py-1">
                            <slot name="dropdown" v-bind="dropdownProps"></slot>
                        </div>
                    </div>
                </transition>
            </div>
        </portal>
    </button>
</template>

<script>
import { createPopper } from '@popperjs/core';
import Toggleable from '@/Utils/Mixins/Toggleable';

export default {
    name: 'Dropdown',

    mixins: [Toggleable],

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

    computed: {
        dropdownProps () {
            return {
                toggle: this.toggle
            };
        },

        placementStyles () {
            return {
                'bottom-center': 'left-0 origin-top',
                'bottom-end': 'right-0 origin-top-right',
                'bottom-start': 'left-0 origin-top-left',
                'top-center': 'left-0 origin-bottom',
                'top-end': 'right-0 origin-bottom-right',
                'top-start': 'left-0 origin-bottom-left'
            };
        },

        styles () {
            return {
                placement: this.placementStyles[this.placement]
            };
        }
    },

    watch: {
        isActive (active) {
            if (active) {
                this.$nextTick(() => {
                    this.popper = createPopper(this.$el, this.$refs.dropdown, {
                        placement: this.placement
                    });
                });
            } else if (this.popper) {
                setTimeout(() => {
                    this.popper.destroy();
                    this.popper = null;
                }, 100);
            }
        }
    },

    methods: {
        hide () {
            if (this.isActive) {
                this.isActive = false;
            }
        },

        show () {
            this.isActive = true;
        },

        toggle () {
            if (this.isActive) {
                this.hide();
            } else {
                this.show();
            }
        }
    }
};
</script>
