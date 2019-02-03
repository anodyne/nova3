<template>
    <div class="notices" :class="parentStyles">
        <nova-toast :session="toastData"></nova-toast>
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
        }

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
