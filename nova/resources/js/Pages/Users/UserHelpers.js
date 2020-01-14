import indexOf from 'lodash/indexOf';

export default {
    props: {
        roles: {
            type: Array,
            required: true
        }
    },

    methods: {
        addRole (role) {
            this.form.fields.roles.push(role.name);
        },

        hasRole (role) {
            const name = (typeof role === 'string')
                ? role
                : role.name;

            return indexOf(this.form.fields.roles, name) > -1;
        },

        removeRole (role) {
            const index = indexOf(this.form.fields.roles, role.name);

            this.form.fields.roles.splice(index, 1);
        }
    }
};
