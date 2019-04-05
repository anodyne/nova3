<template>
    <sidebar-layout>
        <page-header title="Themes">
            <template #controls>
                <inertia-link :href="route('themes.create')" class="button is-primary">
                    Create Theme
                </inertia-link>
            </template>
        </page-header>

        <install-themes
            :pending-themes="pendingThemes"
            @theme-installed="installedThemes.push($event)"
        ></install-themes>

        <div class="row">
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
        </div>
    </sidebar-layout>
</template>

<script>
import axios from '@/Utils/axios';
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
            type: [Array, Object],
            required: true
        },
        themes: {
            type: [Array, Object],
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
                    //
                })
                .catch(({ error }) => {
                    //
                });
        }
    }
};
</script>
