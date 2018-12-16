<template>
    <field-group>
        <template v-if="hasSlot('label')" slot="label">
            <slot name="label">{{ label }}</slot>
        </template>

        <input v-bind="fieldAttributes">

        <template slot="addon-end">
            <a
                v-if="allowShowingPassword"
                role="button"
                @click="toggleFieldType"
            >
                <app-icon
                    v-show="!showPassword"
                    name="view"
                    icon-class="h-5 w-5"
                ></app-icon>
                <app-icon
                    v-show="showPassword"
                    name="hide"
                    icon-class="h-5 w-5"
                ></app-icon>
            </a>
        </template>
    </field-group>
</template>

<script>
import SlotHelpers from '@/mixins/SlotHelpers';

export default {
    mixins: [SlotHelpers],

    props: {
        allowShowingPassword: {
            type: Boolean,
            default: false
        },
        label: {
            type: String,
            default: ''
        },
        name: {
            type: String,
            required: true
        },
        placeholder: {
            type: String,
            default: ''
        }
    },

    data () {
        return {
            showPassword: false
        };
    },

    computed: {
        fieldAttributes () {
            return {
                class: 'field',
                name: this.name,
                placeholder: this.placeholder,
                type: this.fieldType
            };
        },

        fieldType () {
            if (this.showPassword) {
                return 'text';
            }

            return 'password';
        }
    },

    methods: {
        toggleFieldType () {
            this.showPassword = !this.showPassword;
        }
    }
};
</script>
