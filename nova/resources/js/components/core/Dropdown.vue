<template>
    <div :class="dropdownClasses">
        <div class="dropdown-trigger">
            <button
                :class="buttonClasses"
                type="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <slot name="trigger-simple"/>

                <span v-if="hasSlot('trigger')">
                    <slot name="trigger"/>
                </span>
                <icon
                    v-if="hasSlot('trigger')"
                    name="chevron-down"
                    class="dropdown-caret"
                />
            </button>
        </div>

        <div class="dropdown-menu">
            <div class="dropdown-content">
                <slot/>
            </div>
        </div>
    </div>
</template>

<script>
import slots from '../mixins/slots';

export default {

    mixins: [slots],
    props: {
        direction: { type: String, default: '' },
        inverted: { type: Boolean, default: true }
    },

    computed: {
        buttonClasses () {
            return [
                'button',
                this.hasSlot('trigger-simple') ? 'is-flush' : ''
            ];
        },

        dropdownClasses () {
            return [
                'dropdown',
                this.direction != '' ? `is-${this.direction}` : '',
                this.inverted ? 'is-inverted' : ''
            ];
        }
    }
};
</script>
