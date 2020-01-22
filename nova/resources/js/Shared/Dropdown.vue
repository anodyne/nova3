<template>
    <base-dropdown :placement="placement">
        <template #dropdown-trigger="{ toggle }">
            <button
                ref="trigger"
                type="button"
                class="dropdown-trigger"
                @click="toggle"
            >
                <slot></slot>
            </button>
        </template>

        <template #dropdown-panel="{ toggle }">
            <slot name="dropdown" :toggle="toggle"></slot>
        </template>
    </base-dropdown>
</template>

<script>
import BaseDropdown from '@/Shared/BaseDropdown';

export default {
    name: 'Dropdown',

    components: { BaseDropdown },

    props: {
        placement: {
            type: String,
            default: 'bottom-start'
        }
    }
};
</script>
