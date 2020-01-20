<template>
    <div>
        <div>
            <input
                type="text"
                :value="value"
                class="appearance-none outline-none"
                :placeholder="placeholder"
            >
        </div>

        <div v-show="hasResults">
            <div v-if="isSearching">
                <svg
                    class="block fill-current h-6 leading-none"
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
            </div>
            <div v-else>
                Search results
            </div>
        </div>
    </div>
</template>

<script>
import debounce from 'lodash/debounce';
import axios from '@/Utils/axios';

export default {
    name: 'RenderlessTagsInput',

    props: {
        placeholder: {
            type: String,
            default: 'Add tag...'
        },
        searchUrl: {
            type: String,
            required: true
        },
        value: {
            type: [String, Array, Object],
            required: true
        }
    },

    data () {
        return {
            isSearching: false,
            results: [],
            searchTerm: ''
        };
    },

    computed: {
        hasResults () {
            return this.searchTerm !== '' && this.results.length > 0;
        }
    },

    methods: {
        addTag () {
            if (this.newTag.trim().length === 0 || this.value.includes(this.newTag.trim())) {
                return;
            }

            this.$emit('input', [
                ...this.value,
                this.newTag.trim()
            ]);

            this.newTag = '';
        },

        removeTag (tag) {
            this.$emit('input', this.value.filter(t => t !== tag));
        },

        searchForResource: debounce(function () {
            this.isSending = true;

            axios.get(this.searchUrl)
                .then(({ data }) => {
                    this.results = data;
                })
                .catch((error) => {
                    //
                })
                .finally(() => {
                    this.isSearching = false;
                });
        }, 250)
    }
};
</script>
