<template>
    <div>
        <slot></slot>

        <toaster-oven></toaster-oven>
    </div>
</template>

<script>
import ToasterOven from '@/Shared/Toasts/ToasterOven';

export default {
    name: 'MasterInertia',

    components: { ToasterOven }
};
</script>
