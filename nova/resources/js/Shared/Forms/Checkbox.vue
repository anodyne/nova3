<template>
    <label
        ref="label"
        :for="id"
        class="flex items-center"
        :disabled="disabled"
        @click="focus"
        @keydown.prevent.enter="$refs.label.click()"
    >
        <input
            :id="id"
            ref="input"
            v-model="computedValue"
            type="checkbox"
            :disabled="disabled"
            :name="name"
            class="form-checkbox"
            :class="inputClass"
            :value="nativeValue"
            @click.stop
        >

        <span class="ml-2">
            <slot></slot>
        </span>
    </label>
</template>

<script>
import CheckRadioMixin from '@/Utils/Mixins/CheckRadioMixin';

export default {
    name: 'Checkbox',

    mixins: [CheckRadioMixin]
};
</script>
