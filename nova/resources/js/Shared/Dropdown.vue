<template>
    <button
        type="button"
        class="relative transition ease-in-out duration-150"
        @click="show"
    >
        <slot></slot>

        <portal :disabled="false">
            <div
                v-if="isActive"
                class="fixed inset-0 z-999"
                @click="close"
            ></div>

            <div ref="dropdown" class="z-9999">
                <transition
                    enter-active-class="transition ease-out duration-150"
                    enter-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-100"
                    leave-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95"
                    appear
                >
                    <div
                        v-if="isActive"
                        class="absolute mt-2 w-56 rounded-md shadow-lg"
                        :class="styles.placement"
                    >
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
        placement: {
            type: String,
            default: 'bottom-start'
        }
    },

    computed: {
        dropdownProps () {
            return {
                styles: this.styles,
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
                dangerLink: 'group flex items-center w-full px-4 py-2 text-sm font-medium leading-5 text-gray-600 hover:bg-gray-100 hover:text-danger-500 transition ease-in-out duration-150',
                dangerIcon: 'mr-3 h-5 w-5 text-gray-400 group-hover:text-danger-400',
                divider: 'border-t border-gray-100 my-1',
                icon: 'mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500',
                link: 'group flex items-center w-full px-4 py-2 text-sm font-medium leading-5 text-gray-600 hover:bg-gray-100 hover:text-gray-800 transition ease-in-out duration-150',
                placement: this.placementStyles[this.placement],
                text: 'block px-4 py-2 text-sm leading-5 text-gray-700'
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
        close () {
            if (this.isActive) {
                this.isActive = false;
            }
        },

        show () {
            this.disablePortal = false;
            this.isActive = true;
        },

        toggle () {
            if (this.isActive) {
                this.close();
            } else {
                this.show();
            }
        }
    }
};
</script>
