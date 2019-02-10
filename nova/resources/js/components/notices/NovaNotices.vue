<template>
    <div class="notices" aria-atomic="true">
        <nova-alert
            v-for="(alert, index) in alerts"
            :key="index"
            :data="alert"
            @alert-hidden="removeAlert(index)"
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
            alerts: []
        };
    },

    mounted () {
        if (this.session !== null && !isArray(this.session)) {
            this.setData(this.session);
        }

        Nova.$on('nova.alert', (params) => {
            this.setData(params);
        });
    },

    methods: {
        removeAlert (index) {
            setTimeout(() => {
                this.alerts.splice(index, 1);
            }, 2000);
        },

        setData (data) {
            this.alerts.push({
                message: has(data, 'message') ? data.message : '',
                type: has(data, 'type') ? data.type : '',
                actionFunction: has(data, 'actionFunction') ? data.actionFunction : null,
                actionText: has(data, 'actionText') ? data.actionText : ''
            });
        }
    }
};
</script>
