<template>
    <div>
        <page-header pretitle="Presentation" title="Themes">
            <template v-if="can.create" v-slot:controls>
                <a :href="route('themes.create')" class="button is-primary">
                    Create Theme
                </a>
            </template>
        </page-header>

        <install-themes :pending-themes="pendingThemes" @theme-installed="installedThemes.push($event)"></install-themes>

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
                        <a
                            v-if="can.update"
                            :href="route('themes.edit', { theme: theme.id })"
                            class="button is-secondary"
                        >
                            <nova-icon name="edit"></nova-icon>
                        </a>
                        <a
                            v-if="can.delete"
                            :href="route('themes.edit', { theme: theme.id })"
                            class="button is-danger"
                        >
                            <nova-icon name="delete"></nova-icon>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from '@/util/axios';

export default {
    name: 'ManageThemes',

    props: {
        themes: {
            type: Array,
            required: true
        },
        pendingThemes: {
            type: [Array, Object],
            required: true
        },
        can: {
            type: Object,
            required: true
        }
    },

    data () {
        return {
            installedThemes: this.themes
        };
    },

    methods: {
        handleThemeInstall (theme) {
            this.installedThemes.push(theme);
        }
    }
};
</script>
