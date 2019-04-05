<template>
    <div v-show="hasThemeToBeInstalled" class="max-w-md mb-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Awaiting Installation</div>
            </div>

            <div class="card-body mt-6">
                <transition-group
                    enter-active-class="animated fadeIn"
                    leave-active-class="animated fadeOut"
                >
                    <div
                        v-for="(theme, index) in themes"
                        :key="theme.location"
                        class="p-3 rounded flex items-center justify-between"
                        :class="{ 'bg-grey-50': index % 2 === 0 }"
                    >
                        themes/{{ theme.location }}
                        <button class="button is-small is-dark my-0" @click="install(index)">
                            Install
                        </button>
                    </div>
                </transition-group>
            </div>
        </div>
    </div>
</template>

<script>
import axios from '@/Utils/axios';

export default {
    name: 'InstallThemes',

    props: {
        pendingThemes: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            themes: this.pendingThemes
        };
    },

    computed: {
        hasThemeToBeInstalled () {
            return Object.keys(this.themes).length > 0;
        }
    },

    methods: {
        install (index) {
            this.$toast.open('This is my toast');
            // axios.post(route('themes.install'), { theme: this.themes[index] })
            //     .then(({ data }) => {
            //         this.themes.splice(index, 1);

            //         this.$emit('theme-installed', { theme });

            //         // this.$toast.withMessage(`${theme.name} theme was successfully installed.`).success();
            //     })
            //     .catch(({ error }) => {
            //         // this.$toast.withMessage('The theme does not have a QuickInstall file.').error();
            //     });
        }
    }
};
</script>
