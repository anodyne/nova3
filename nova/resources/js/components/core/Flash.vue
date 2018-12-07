<template>
    <transition name="fade">
        <div
            v-show="show"
            :class="classes"
            role="alert"
        >
            <h4
                v-if="heading != ''"
                class="alert-heading"
            >{{ heading }}</h4>
            <p v-if="heading != ''">{{ body }}</p>
            <p v-if="heading == ''">{{ body }}</p>
        </div>
    </transition>
</template>

<script>
export default {
    props: ['message', 'title', 'level'],

    data () {
        return {
            body: '',
            show: false,
            type: '',
            heading: '',
            startTransition: false
        };
    },

    computed: {
        classes () {
            return ['alert', 'alert-flash', `alert-${this.type}`];
        }
    },

    watch: {
        startTransition (newValue, oldValue) {
            if (newValue) {
                const self = this;

                $('.alert-flash').fadeOut(() => {
                    self.show = false;
                    self.startTransition = false;
                });
            }
        }
    },

    mounted () {
        const self = this;

        if (this.message) {
            this.flash(this.message, this.title, this.level);
        }

        this.$events.$on('flash', (message, title, level) => { return self.flash(message, title, level); });
    },

    methods: {
        flash (message, title, level) {
            this.body = message;
            this.type = level;
            this.heading = title;
            this.show = true;

            this.hide();
        },

        hide () {
            const self = this;

            setTimeout(() => {
                self.startTransition = true;
            }, 4000);
        }
    }
};
</script>

<style lang="scss">
	.fade-enter-active, .fade-leave-active {
		transition: opacity .5s
	}

	.fade-enter, .fade-leave-to {
		opacity: 0
	}
</style>
