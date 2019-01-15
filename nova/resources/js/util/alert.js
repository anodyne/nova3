// import Nova from '../nova';

export default class Alert {
    constructor (config) {
        this.config = {
            ...{
                position: 'center',
                showConfirmButton: false,
                timer: 3500,
                toast: false
            },
            ...config
        };
        this.data = {};
    }

    persist () {
        this.config.position = 'center';
        this.config.showConfirmButton = true;
        this.config.timer = null;
        this.config.toast = false;

        return this;
    }

    persistError () {
        this.persist();
        this.error();
    }

    persistInfo () {
        this.persist();
        this.info();
    }

    persistQuestion () {
        this.persist();
        this.question();
    }

    persistSuccess () {
        this.persist();
        this.success();
    }

    persistWarning () {
        this.persist();
        this.warning();
    }

    toast () {
        this.config.position = 'bottom-end';
        this.config.showConfirmButton = false;
        this.config.timer = 3500;
        this.config.toast = true;

        return this;
    }

    toastError () {
        this.toast();
        this.error();
    }

    toastInfo () {
        this.toast();
        this.info();
    }

    toastQuestion () {
        this.toast();
        this.question();
    }

    toastSuccess () {
        this.toast();
        this.success();
    }

    toastWarning () {
        this.toast();
        this.warning();
    }

    with (key, value = null) {
        if (Array.isArray(key)) {
            this.data = {
                ...this.data,
                ...key
            };
        } else {
            this.data[key] = value;
        }

        return this;
    }

    withMessage (value) {
        this.data.message = value;

        return this;
    }

    withTitle (value) {
        this.data.title = value;

        return this;
    }

    error () {
        this.data.type = 'error';

        return this.createAlert();
    }

    info () {
        this.data.type = 'info';

        return this.createAlert();
    }

    question () {
        this.data.type = 'question';

        return this.createAlert();
    }

    success () {
        this.data.type = 'success';

        return this.createAlert();
    }

    warning () {
        this.data.type = 'warning';

        return this.createAlert();
    }

    createAlert () {
        const content = {
            type: this.data.type,
            title: this.data.title,
            message: this.data.message
        };

        Nova.$emit('nova.alert', content, this.config);
    }
}
