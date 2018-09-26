<template>
    <div
        v-cloak
        :class="wrapperClasses"
    >
        <input
            v-if="type === 'checkbox' || type === 'switch'"
            :name="name"
            :value="value"
            type="checkbox"
        >
        <input
            v-if="type === 'radio'"
            :name="name"
            :value="value"
            type="radio"
        >

        <div :class="stateClasses">
            <slot name="icon"/>
            <slot name="label"/>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        type: { type: String, required: true },
        name: { type: String, required: true },
        value: { type: String, required: true }
    },

    computed: {
        stateClasses () {
            const pieces = ['state'];

            if (this.type === 'switch') {
                pieces.push('p-success');
            }

            return pieces;
        },

        wrapperClasses () {
            const pieces = ['pretty', 'p-smooth'];

            if (this.type === 'checkbox') {
                pieces.push('p-default');
                pieces.push('p-curve');
                pieces.push('p-thick');
            }

            if (this.type === 'radio') {
                pieces.push('p-default');
                pieces.push('p-round');
                pieces.push('p-thick');
            }

            if (this.type === 'switch') {
                pieces.push('p-switch');
                pieces.push('p-slim');
            }

            return pieces;
        }
    }
};
</script>
