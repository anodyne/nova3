import has from 'lodash/has';

export default {
    props: {
        session: {
            type: Object,
            default: null
        }
    },

    data () {
        return {
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

    methods: {
        close () {
            if (!this.isActive) {
                return;
            }

            clearTimeout(this.timer);
            this.isActive = false;
        },

        setData (data) {
            this.message = has(data, 'message') ? data.message : '';
            this.position = has(data, 'position') ? data.position : 'is-bottom';
            this.type = has(data, 'type') ? data.type : 'is-dark';
        }
    },

    mounted () {
        if (this.session !== null) {
            this.setData(this.session);
            this.show();
        }
    }
};
