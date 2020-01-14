<template>
    <div class="relative">
        <div
            v-if="open"
            class="fixed inset-0"
            @click="hide()"
        ></div>

        <button
            ref="trigger"
            type="button"
            class="relative flex items-center cursor-pointer select-none text-gray-600 hover:text-gray-700 focus:outline-none"
            @click="toggle()"
        >
            <slot></slot>
        </button>

        <transition
            enter-active-class="transition-all transition-fastest ease-out"
            enter-class="opacity-0 scale-75"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition-all transition-faster ease-in"
            leave-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-75"
            appear
        >
            <div
                v-if="open"
                ref="dropdown"
                class="absolute flex flex-col min-w-40 rounded bg-gray-900 z-9999 shadow-md mt-2 overflow-hidden"
                :class="styles.origin"
            >
                <slot name="dropdown" :dropdownProps="dropdownProps"></slot>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    name: 'Dropdown',

    props: {
        placement: {
            type: String,
            default: 'bottom-start'
        }
    },

    data () {
        return {
            open: false
        };
    },

    computed: {
        dropdownProps () {
            return {
                toggle: this.toggle
            };
        },

        styles () {
            return {
                origin: {
                    'left-0 origin-bottom-left': this.placement === 'top-start',
                    'right-0 origin-bottom-right': this.placement === 'top-end',
                    'left-0 origin-top-left': this.placement === 'bottom-start',
                    'right-0 origin-top-right': this.placement === 'bottom-end'
                }
            };
        }
    },

    methods: {
        hide () {
            if (this.open) {
                this.open = false;
            }
        },

        show () {
            this.open = true;
        },

        toggle () {
            if (this.open) {
                this.hide();
            } else {
                this.show();
            }
        }
    }
};
</script>
