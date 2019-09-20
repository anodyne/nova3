<template>
    <button
        class="button relative disabled:opacity-75 disabled:cursor-not-allowed"
        :disabled="isLoading"
        role="button"
        v-bind="$attrs"
        v-on="$listeners"
    >
        <span :class="{ 'text-transparent': isLoading }">
            <slot></slot>
        </span>

        <svg
            v-if="isLoading"
            class="absolute block fill-current h-3 leading-none"
            viewBox="0 0 120 30"
            xmlns="http://www.w3.org/2000/svg"
        >
            <circle
                cx="15"
                cy="15"
                r="15"
            >
                <animate
                    attributeName="r"
                    from="15"
                    to="15"
                    begin="0s"
                    dur="0.8s"
                    values="15;9;15"
                    calcMode="linear"
                    repeatCount="indefinite"
                />
                <animate
                    attributeName="fill-opacity"
                    from="1"
                    to="1"
                    begin="0s"
                    dur="0.8s"
                    values="1;.5;1"
                    calcMode="linear"
                    repeatCount="indefinite"
                />
            </circle>
            <circle
                cx="60"
                cy="15"
                r="9"
                fill-opacity="0.3"
            >
                <animate
                    attributeName="r"
                    from="9"
                    to="9"
                    begin="0s"
                    dur="0.8s"
                    values="9;15;9"
                    calcMode="linear"
                    repeatCount="indefinite"
                />
                <animate
                    attributeName="fill-opacity"
                    from="0.5"
                    to="0.5"
                    begin="0s"
                    dur="0.8s"
                    values=".5;1;.5"
                    calcMode="linear"
                    repeatCount="indefinite"
                />
            </circle>
            <circle
                cx="105"
                cy="15"
                r="15"
            >
                <animate
                    attributeName="r"
                    from="15"
                    to="15"
                    begin="0s"
                    dur="0.8s"
                    values="15;9;15"
                    calcMode="linear"
                    repeatCount="indefinite"
                />
                <animate
                    attributeName="fill-opacity"
                    from="1"
                    to="1"
                    begin="0s"
                    dur="0.8s"
                    values="1;.5;1"
                    calcMode="linear"
                    repeatCount="indefinite"
                />
            </circle>
        </svg>
    </button>
</template>

<script>
export default {
    name: 'StatefulButton',

    props: {
        disabled: {
            type: Boolean,
            default: false
        },
        loading: {
            type: Boolean,
            default: false
        }
    },

    computed: {
        isLoading () {
            return this.disabled || this.loading;
        }
    }
};
</script>
