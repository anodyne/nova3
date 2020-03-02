<template>
    <form-field
        :label="label"
        :field-id="name"
    >
        <input v-bind="fieldAttributes">

        <template v-if="allowShowingPassword" #addon-after>
            <button
                type="button"
                class="field-addon"
                @click="toggleFieldType"
            >
                <div v-show="showPassword" class="leading-0">
                    <icon name="eye-off"></icon>
                </div>
                <div v-show="!showPassword" class="leading-0">
                    <icon name="eye"></icon>
                </div>
            </button>
        </template>
    </form-field>
</template>

<script>
export default {
    name: 'PasswordField',

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
                id: this.name,
                placeholder: this.placeholder,
                type: this.fieldType,
                'data-cy': this.name
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
