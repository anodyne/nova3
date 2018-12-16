<template>
    <div>
        <a
            role="button"
            class="absolute pin-l pl-4"
            @click="toggleMenu"
        >
            <app-icon name="menu" icon-class="h-6 w-6 text-grey-500"></app-icon>
        </a>

        <div class="absolute pin-t pin-l z-50 h-screen w-0" :class="{ 'w-full': isOpen }">
            <div class="relative bg-white p-6 h-screen">
                Menu
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            isOpen: true
        };
    },

    methods: {
        toggleMenu () {
            this.isOpen = !this.isOpen;
        }
    }
};
</script>

<style>
.drawer {

}
</style>
