<template>
    <div class="alerts" aria-atomic="true">
        <alert
            v-for="(alert, index) in alerts"
            :key="index"
            :data="alert"
            @alert-hidden="removeAlert(index)"
        ></alert>
    </div>
</template>

<script>
import has from 'lodash/has';
import isArray from 'lodash/isArray';
import Alert from './Alert';

export default {
    name: 'AlertsManager',

    components: { Alert },

    data () {
        return {
            alerts: []
        };
    },

    mounted () {
        if (novaAlerts) {
            this.setData(novaAlerts);
        }

        this.$alert.emitter.$on('nova.alert', (alert) => {
            this.setData(alert);
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
