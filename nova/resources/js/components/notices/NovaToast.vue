<template>
    <transition :enter-active-class="transition.enter" :leave-active-class="transition.leave">
        <div
            v-show="isActive"
            class="toast"
            :class="[type, position]"
        >
            <nova-icon v-if="type === 'is-success'" name="check-circle"></nova-icon>
            <nova-icon v-if="type === 'is-danger'" name="alert-circle"></nova-icon>

            <div v-html="message"></div>
        </div>
    </transition>
</template>

<script>
import has from 'lodash/has';

export default {
    name: 'NovaToast',

    props: {
        session: {
            type: Object,
            default: null
        }
    },

    data () {
        return {
            duration: 3000,
            isActive: false,
            message: '',
            position: 'is-bottom-right',
            type: 'is-dark'
        };
    },

    computed: {
        transition () {
            switch (this.position) {
                case 'is-bottom':
                default:
                    return {
                        enter: 'animated faster fadeInUp',
                        leave: 'animated faster fadeOutDown'
                    };

                case 'is-top':
                    return {
                        enter: 'animated faster fadeInDown',
                        leave: 'animated faster fadeOutUp'
                    };

                case 'is-bottom-right':
                case 'is-top-right':
                    return {
                        enter: 'animated faster fadeInRight',
                        leave: 'animated faster fadeOutRight'
                    };

                case 'is-bottom-left':
                case 'is-top-left':
                    return {
                        enter: 'animated faster fadeInLeft',
                        leave: 'animated faster fadeOutLeft'
                    };
            }
        }
    },

    mounted () {
        if (this.session !== null) {
            this.setData(this.session);
            this.show();
        }

        Nova.$on('nova.notices.toast', (params) => {
            this.setData(params);
            this.show();
        });
    },

    methods: {
        close () {
            clearTimeout(this.timer);
            this.isActive = false;
        },

        setData (data) {
            this.message = has(data, 'message') ? data.message : '';
            this.position = has(data, 'position') ? data.position : 'is-bottom';
            this.type = has(data, 'type') ? data.type : 'is-dark';
        },

        show () {
            this.isActive = true;

            this.timer = setTimeout(() => {
                return this.close();
            }, this.duration);
        }
    }
};
</script>
