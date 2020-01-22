<template>
    <div class="dropdown-wrapper">
        <div
            v-if="isActive"
            class="dropdown-overlay"
            @click="hide"
        ></div>

        <slot name="dropdown-trigger" v-bind="dropdownProps"></slot>

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
                v-if="isActive"
                ref="dropdown"
                class="dropdown-panel"
                :class="styles.placement"
            >
                <slot name="dropdown-panel" v-bind="dropdownProps"></slot>
            </div>
        </transition>
    </div>
</template>

<script>
import Toggleable from '@/Utils/Mixins/Toggleable';

export default {
    name: 'BaseDropdown',

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
                toggle: this.toggle
            };
        },

        styles () {
            return {
                placement: `dropdown-${this.placement}`
            };
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
