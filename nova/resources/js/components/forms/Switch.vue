<template>
    <span
        :class="wrapperClasses"
        :aria-checked="value.toString()"
        role="checkbox"
        tabindex="0"
        @click="toggle"
        @keydown.space.prevent="toggle"
    >
        <span :class="backgroundClasses"/>
        <span :class="indicatorClasses"/>

        <input
            :name="name"
            :value="value"
            type="checkbox"
            class="hidden"
        >
    </span>
</template>

<script>
export default {
    props: {
        name: { type: String, required: true },
        small: { type: Boolean, default: false },
        large: { type: Boolean, default: false },
        value: { required: true }
    },

    computed: {
        backgroundClasses () {
            const classes = ['switch-background'];

            if (this.isChecked) {
                classes.push('active');
            }

            return classes;
        },

        indicatorClasses () {
            const classes = ['switch-indicator'];

            if (this.isChecked) {
                classes.push('active');
            }

            return classes;
        },

        isChecked () {
            if (typeof (this.value) === typeof (true)) {
                return this.value;
            }

            return this.value == 'true';
        },

        wrapperClasses () {
            const classes = ['switch-wrapper'];

            if (this.large) {
                classes.push('is-large');
            }

            if (this.small) {
                classes.push('is-small');
            }

            return classes;
        }
    },

    methods: {
        toggle () {
            this.$emit('input', !this.isChecked);
        }
    }
};
</script>
