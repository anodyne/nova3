<template>
    <div class="relative">
        <div
            v-if="isActive"
            class="fixed inset-0"
            @click="hide"
        ></div>

        <slot name="dropdown-trigger" v-bind="dropdownProps"></slot>

        <portal v-if="isActive" to="dropdown">
            <transition
                enter-active-class="transition ease-out duration-100"
                enter-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95"
                appear
            >
                <div
                    ref="dropdown"
                    class="absolute mt-2 w-56 rounded-md shadow-lg z-9999"
                >
                    <div class="rounded-md bg-white shadow-xs py-1">
                        <slot name="dropdown-panel" v-bind="dropdownProps"></slot>
                    </div>
                </div>
            </transition>
        </portal>
    </div>
</template>

<script>
import Toggleable from '@/Utils/Mixins/Toggleable';
import Popper from 'popper.js';

export default {
    name: 'BaseDropdown',

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

        styles () {
            return {
                placement: `dropdown-${this.placement}`
            };
        }
    },

    watch: {
        isActive (active) {
            if (active) {
                this.$nextTick(() => {
                    this.popper = new Popper(this.$el, this.$refs.dropdown, {
                        placement: this.placement,
                        modifiers: {
                            preventOverflow: { boundariesElement: this.boundary }
                        }
                    });
                });
            } else if (this.popper) {
                setTimeout(() => this.popper.destroy(), 100);
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
