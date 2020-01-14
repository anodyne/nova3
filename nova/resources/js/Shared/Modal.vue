<template>
    <portal to="modals">
        <div
            v-if="showModal"
            class="fixed inset-0 flex justify-center pt-16"
            @click="close"
        >
            <transition
                enter-class="opacity-0"
                enter-active-class="transition-all transition-fastest ease-out-quad"
                enter-to-class="opacity-100"
                leave-class="opacity-100"
                leave-active-class="transition-all transition-medium ease-in-quad"
                leave-to-class="opacity-0"
                appear
                @before-leave="backdropLeaving = true"
                @after-leave="backdropLeaving = false"
            >
                <div v-if="showBackdrop">
                    <div class="absolute inset-0 bg-black opacity-50"></div>
                </div>
            </transition>

            <transition
                enter-class="opacity-0 scale-125"
                enter-active-class="transition-all transition-medium ease-out-quad"
                enter-to-class="opacity-100 scale-100"
                leave-class="opacity-100 scale-100"
                leave-active-class="transition-all transition-medium ease-in-quad"
                leave-to-class="opacity-0 scale-125"
                appear
                @before-leave="cardLeaving = true"
                @after-leave="cardLeaving = false"
            >
                <div v-if="showContent" class="relative">
                    <div class="min-w-lg max-w-lg w-full bg-white rounded shadow-2xl overflow-hidden">
                        <div class="px-6 pt-4 font-semibold text-gray-900 text-xl">{{ title }}</div>

                        <div class="px-6 py-4">
                            <slot></slot>
                        </div>

                        <div class="flex items-center justify-end mt-4 px-6 py-4 bg-gray-100">
                            <slot name="footer"></slot>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </portal>
</template>

<script>
export default {
    name: 'Modal',

    props: {
        open: {
            type: Boolean,
            default: false
        },
        title: {
            type: String,
            required: true
        }
    },

    data () {
        return {
            backdropLeaving: false,
            cardLeaving: false,
            showBackdrop: false,
            showContent: false,
            showModal: false
        };
    },

    computed: {
        leaving () {
            return this.backdropLeaving || this.cardLeaving;
        }
    },

    watch: {
        open: {
            handler (newValue) {
                if (newValue) {
                    this.show();
                } else {
                    this.close();
                }
            },
            immediate: true
        },

        leaving (newValue) {
            if (newValue === false) {
                this.showModal = false;
                this.$emit('close');
            }
        }
    },

    created () {
        const onEscape = (e) => {
            if (this.open && e.keyCode === 27) {
                this.close();
            }
        };

        document.addEventListener('keydown', onEscape);

        this.$once('hook:destroyed', () => {
            document.removeEventListener('keydown', onEscape);
        });
    },

    methods: {
        close () {
            this.showBackdrop = false;
            this.showContent = false;
        },

        show () {
            this.showModal = true;
            this.showBackdrop = true;
            this.showContent = true;
        }
    }
};
</script>
