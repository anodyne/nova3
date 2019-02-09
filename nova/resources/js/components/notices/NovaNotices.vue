<template>
    <div
        class="notices"
        :class="parentStyles"
        aria-atomic="true"
    >
        <nova-alert
            v-for="(alert, index) in alerts"
            :key="index"
            :data="alert"
        ></nova-alert>
    </div>
</template>

<script>
import has from 'lodash/has';
import isArray from 'lodash/isArray';

export default {
    name: 'NovaNotices',

    props: {
        session: {
            type: [Array, Object],
            default: null
        }
    },

    data () {
        return {
            alerts: [],
            position: 'is-bottom',
            type: 'is-dark'
        };
    },

    computed: {
        parentStyles () {
            return {
                'is-bottom': this.position.includes('bottom'),
                'is-top': this.position.includes('top')
            };
        }
    },

    mounted () {
        if (this.session !== null && !isArray(this.session)) {
            this.setDadta(this.session);
        }

        Nova.$on('nova.alert', (params) => {
            this.setData(params);
        });
    },

    methods: {
        setData (data) {
            this.type = has(data, 'type') ? data.type : 'is-dark';
            this.position = has(data, 'position') ? data.position : 'is-bottom';

            this.alerts.push({
                message: has(data, 'message') ? data.message : '',
                type: this.type,
                position: this.position,
                actionFunction: has(data, 'actionFunction') ? data.actionFunction : null,
                actionText: has(data, 'actionText') ? data.actionText : ''
            });
        }
    }
};
</script>
