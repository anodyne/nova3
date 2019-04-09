<template>
    <sidebar-layout>
        <page-header title="Themes">
            <template v-if="can.create" #controls>
                <inertia-link :href="route('themes.create')" class="button is-primary">
                    Create Theme
                </inertia-link>
            </template>
        </page-header>

        <install-themes
            :pending-themes="pendingThemes"
            @theme-installed="installedThemes.push($event)"
        ></install-themes>

        <transition-group
            tag="div"
            class="row"
            leave-active-class="animated fadeOut"
        >
            <div
                v-for="(theme, index) in installedThemes"
                :key="theme.id"
                class="col-6 mb-6"
            >
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ theme.name }}</div>
                        <div class="card-subtitle">themes/{{ theme.location }}</div>
                    </div>

                    <div class="card-body">
                        <button class="button is-small is-secondary" @click="makeToast">Test</button>
                    </div>

                    <div class="card-footer">
                        <inertia-link
                            v-if="can.update"
                            :href="route('themes.edit', { theme })"
                            class="button is-secondary"
                        >
                            <nova-icon name="edit"></nova-icon>
                        </inertia-link>
                        <a
                            v-if="can.delete"
                            role="button"
                            class="button is-danger"
                            @click="remove(theme, index)"
                        >
                            <nova-icon name="delete"></nova-icon>
                        </a>
                    </div>
                </div>
            </div>
        </transition-group>
    </sidebar-layout>
</template>

<script>
import axios from '@/Utils/axios';
import findIndex from 'lodash/findIndex';
import InstallThemes from '@/Pages/Themes/InstallThemes';

export default {
    name: 'ManageThemes',

    components: {
        InstallThemes
    },

    props: {
        can: {
            type: Object,
            required: true
        },
        pendingThemes: {
            type: Object,
            required: true
        },
        themes: {
            type: Array,
            required: true
        }
    },

    data () {
        return {
            installedThemes: this.themes
        };
    },

    methods: {
        makeToast () {
            this.$toast.message('Duis culpa voluptate enim ullamco eiusmod. Sint ad et ut amet deserunt amet. Reprehenderit duis id aute nostrud fugiat elit. Elit elit id aute tempor dolore laborum labore velit cillum aliqua sunt laboris. Nisi qui do duis ullamco pariatur ad ad elit sint fugiat deserunt enim ullamco cillum.').make();
        },

        remove (theme) {
            axios.delete(route('themes.destroy', { theme }))
                .then(({ data }) => {
                    const index = findIndex(this.installedThemes, { id: data.id });

                    this.installedThemes.splice(index, 1);

                    this.$toast.message('Theme was successfully deleted.').success();
                })
                .catch(({ error }) => {
                    this.$toast.message('There was a problem removing the theme.').error();
                });
        }
    }
};
</script>
