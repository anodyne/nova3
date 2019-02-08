<template>
    <div class="tabs">
        <ul
            class="tabs-nav"
            :class="{ 'tabs-nav-pills': pills }"
            role="tablist"
        >
            <li
                v-for="tab in tabs"
                :key="tab.label"
                class="tabs-nav-item"
                :class="{ 'active': tabIsActive(tab) }"
                role="presentation"
            >
                <a
                    role="button"
                    class="tabs-nav-link"
                    @click="activateTab(tab)"
                >
                    {{ tab.label }}
                </a>
            </li>
        </ul>

        <div class="tabs-content">
            <slot></slot>
        </div>
    </div>
</template>

<script>
import find from 'lodash/find';

export default {
    name: 'TabList',

    provide () {
        return {
            tabListState: this.sharedState
        };
    },

    props: {
        pills: {
            type: Boolean,
            default: false
        }
    },

    data () {
        return {
            sharedState: {
                activeId: null
            },
            tabs: []
        };
    },

    computed: {
        firstActiveTab () {
            return find(this.tabs, 'active');
        }
    },

    mounted () {
        this.tabs = this.$children;

        const firstActiveTab = (this.firstActiveTab)
            ? this.firstActiveTab
            : this.tabs[0];

        this.activateTab(firstActiveTab);
    },

    methods: {
        activateTab (tab) {
            this.sharedState.activeId = tab.id;
        },

        tabIsActive (tab) {
            return tab.id === this.sharedState.activeId;
        }
    }
};
</script>
