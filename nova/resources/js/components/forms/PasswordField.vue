<template>
    <form-field :label="label" :field-id="name">
        <div class="field-group">
            <input v-bind="fieldAttributes">

            <a
                v-if="allowShowingPassword"
                role="button"
                class="field-addon"
                @click="toggleFieldType"
            >
                <div v-show="showPassword" class="leading-none">
                    <app-icon name="hide"></app-icon>
                </div>
                <div v-show="!showPassword" class="leading-none">
                    <app-icon name="show"></app-icon>
                </div>
            </a>
        </div>
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
