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
                v-for="theme in installedThemes"
                :key="theme.id"
                class="col-6 mb-6"
            >
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ theme.name }}</div>
                        <div class="card-subtitle">themes/{{ theme.location }}</div>
                    </div>

                    <div class="card-body"></div>

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
                            @click="remove(theme)"
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
import InstallThemes from '@/Pages/Themes/Install';

export default {
    components: {
        InstallThemes
    },

    props: {
        can: {
            type: Object,
            required: true
        },
        pendingThemes: {
            type: [Array, Object],
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
        remove (theme) {
            axios.delete(route('themes.destroy', { theme }))
                .then(({ data }) => {
                    const index = findIndex(this.installedThemes, { id: data.id });

                    this.$toast
                        .message(`${this.installedThemes[index].name} theme was removed.`)
                        .success();

                    this.installedThemes.splice(index, 1);
                })
                .catch(({ error }) => {
                    this.$toast.message('There was a problem removing the theme.').error();
                });
        }
    }
};
</script>
