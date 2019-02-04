<template>
    <!-- <transition
        :enter-active-class="transition.enter"
        :leave-active-class="transition.leave"
    >
        <div
            v-show="isActive"
            class="snackbar"
            :class="[type, position]"
        >
            <p class="message">{{ message }}</p>

            <div
                v-if="actionText"
                class="action"
                :class="type"
                @click="action"
            >
                <button class="button button-dark">{{ actionText }}</button>
            </div>
        </div>
    </transition> -->
    <div></div>
</template>

<script>
export default {
    name: 'NovaSnackbar'

    // mixins: [NoticesMixin],

    // props: {
    //     actionText: {
    //         type: String,
    //         default: 'OK'
    //     },
    //     onAction: {
    //         type: Function,
    //         default: () => {}
    //     },
    //     indefinite: {
    //         type: Boolean,
    //         default: false
    //     }
    // },

    // data () {
    //     return {
    //         newDuration: this.duration || config.defaultSnackbarDuration
    //     };
    // },

    // methods: {
    //     action () {
    //         this.onAction();
    //         this.close();
    //     }
    // }
};
</script>
