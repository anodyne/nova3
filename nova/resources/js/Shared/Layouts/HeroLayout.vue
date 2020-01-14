<template>
    <div>
        <header class="flex h-64 bg-primary-500 mb-12"></header>

        <main>
            <div class="container">
                <slot></slot>
            </div>
        </main>
    </div>
</template>

<script>
export default {
    name: 'HeroLayout',

    props: {
        page: {
            type: Object,
            default: () => ({})
        },
        theme: {
            type: Object,
            default: () => ({})
        }
    }
};
</script>
