<template>
    <label
        class="flex items-center"
        @click="toggle()"
        @keydown.space.prevent="toggle()"
    >
        <span
            ref="toggleSwitch"
            :class="{ 'bg-gray-200': !value, [`bg-${color}`]: value }"
            class="relative inline-block flex-no-shrink h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:shadow-outline"
            role="checkbox"
            tabindex="0"
            :aria-checked="value.toString()"
        >
            <span
                aria-hidden="true"
                :class="{ 'translate-x-5': value, 'translate-x-0': !value }"
                class="relative inline-block h-5 w-5 rounded-full bg-white shadow transform transition ease-in-out duration-200"
            >
                <span
                    :class="{ 'opacity-0 ease-out duration-100': value, 'opacity-100 ease-in duration-200': !value }"
                    class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity"
                >
                    <slot name="icon-off" v-bind="iconProps">
                        <svg
                            :class="styles.iconOff"
                            fill="none"
                            viewBox="0 0 12 12"
                        >
                            <path
                                d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </slot>
                </span>
                <span
                    :class="{ 'opacity-100 ease-in duration-200': value, 'opacity-0 ease-out duration-100': !value }"
                    class="absolute inset-0 h-full w-full flex items-center justify-center transition-opacity"
                >
                    <slot name="icon-on" v-bind="iconProps">
                        <svg
                            :class="styles.iconOn"
                            fill="currentColor"
                            viewBox="0 0 12 12"
                        >
                            <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z" />
                        </svg>
                    </slot>
                </span>
            </span>
        </span>

        <div v-if="hasContentSlot" class="ml-3 font-medium text-gray-700">
            <slot></slot>
            <slot v-if="!switched" name="content-off"></slot>
            <slot v-if="switched" name="content-on"></slot>
        </div>
    </label>
</template>

<script>
import SlotHelpers from '@/Utils/Mixins/SlotHelpers';

export default {
    name: 'ToggleSwitch',

    mixins: [SlotHelpers],

    props: {
        color: {
            type: String,
            default: 'primary-500'
        },
        value: {
            type: Boolean,
            required: true
        }
    },

    data () {
        return {
            switched: this.value
        };
    },

    computed: {
        hasContentSlot () {
            return this.hasSlot('default')
                || this.hasSlot('content-off')
                || this.hasSlot('content-on');
        },

        iconProps () {
            return {
                styles: this.styles
            };
        },

        styles () {
            return {
                iconOff: 'h-3 w-3 text-gray-400',
                iconOn: `h-3 w-3 text-${this.color}`
            };
        }
    },

    watch: {
        switched (val) {
            this.$emit('input', val);
        }
    },

    methods: {
        toggle () {
            this.$refs.toggleSwitch.focus();

            this.switched = !this.switched;
        }
    }
};
</script>
