<template>
    <label
        ref="label"
        :for="id"
        class="inline-flex items-center"
        :disabled="disabled"
        :data-cy="name"
        @click="focus"
        @keydown.prevent.enter="$refs.label.click()"
    >
        <input
            :id="id"
            ref="input"
            v-model="computedValue"
            type="radio"
            :disabled="disabled"
            :name="name"
            class="form-radio"
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
    name: 'RadioButton',

    mixins: [CheckRadioMixin]
};
</script>
