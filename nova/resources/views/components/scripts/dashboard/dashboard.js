Nova.extend({
    data: {
        menuOpen: false
    },

    methods: {
        toggleMenu () {
            this.menuOpen = !this.menuOpen;
        }
    }
});
