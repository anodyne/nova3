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
                        <button class="button button-small button-dark my-0" @click="install(index)">
                            Install
                        </button>
                    </div>
                </transition-group>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        pendingThemes: {
            type: [Array, Object],
            required: true
        }
    },

    data () {
        return {
            form: {
                theme: ''
            },
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
            this.form.fields.theme = this.themes[index].location;

            this.form.post({
                url: this.$route('themes.install'),
                then: (data) => {
                    this.$toast.message(`${data.name} theme was installed.`).success();

                    this.themes.splice(index, 1);

                    this.$emit('theme-installed', data);
                }
            });
        }
    }
};
</script>
