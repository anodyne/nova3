export default class FormErrors {
    constructor (errors) {
        this.errors = errors;
    }

    first (key) {
        if (this.has(key)) {
            return this.errors[key][0];
        }

        return false;
    }

    get (key) {
        if (this.has(key)) {
            return this.errors[key];
        }

        return false;
    }

    has (key) {
        return Object.prototype.hasOwnProperty.call(this.errors, key);
    }
}
