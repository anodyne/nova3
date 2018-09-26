<template>
    <div class="page-header">
        <div class="page-header-content">
            <div
                v-if="hasSlot('pretitle')"
                class="page-header-pretitle"
            >
                <slot name="pretitle"/>
            </div>

            <div class="page-header-title">
                <slot name="title">{{ pageTitle }}</slot>
            </div>
        </div>

        <div
            v-if="hasSlot('controls')"
            class="page-header-controls"
        >
            <slot name="controls"/>
        </div>
    </div>
</template>

<script>
import slots from '../mixins/slots';

export default {
    mixins: [slots],

    computed: {
        pageTitle () {
            return 'TESTING';
            // return Nova.page.name;
        }
    }
};
</script>
