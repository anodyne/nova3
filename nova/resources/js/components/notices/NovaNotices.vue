<template>
    <div class="notices" :class="parentStyles">
        <nova-toast :session="toastData"></nova-toast>
        <nova-snackbar :session="snackbarData"></nova-snackbar>
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
            position: '',
            type: ''
        };
    },

    computed: {
        parentStyles () {
            return {
                'is-bottom': this.position.includes('bottom'),
                'is-top': this.position.includes('top')
            };
        },

        snackbarData () {
            if (has(this.session, 'snackbar')) {
                return this.session.snackbar;
            }

            return null;
        },

        toastData () {
            if (has(this.session, 'toast')) {
                return this.session.toast;
            }

            return null;
        }
    },

    mounted () {
        if (this.session !== null && !isArray(this.session)) {
            if (has(this.session, 'toast')) {
                this.setData(this.session.toast);
            }

            if (has(this.session, 'snackbar')) {
                this.setData(this.session.snackbar);
            }
        }

        Nova.$on('nova.notices.snackbar', (params) => {
            this.setData(params);
        });

        Nova.$on('nova.notices.toast', (params) => {
            this.setData(params);
        });
    },

    methods: {
        setData (data) {
            this.type = has(data, 'type') ? data.type : 'is-dark';
            this.position = has(data, 'position') ? data.position : 'is-bottom';
        }
    }
};
</script>
