import Modal from '@/Shared/Modal';

export default {
    components: { Modal },

    data () {
        return {
            deletingItem: {},
            modalIsShown: false
        };
    },

    methods: {
        hideModal () {
            this.deletingItem = {};
            this.modalIsShown = false;
        },

        showModal (deletingItem) {
            this.deletingItem = deletingItem;
            this.modalIsShown = true;
        }
    }
};
