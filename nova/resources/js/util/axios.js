import axios from 'axios';

const instance = axios.create();

instance.interceptors.response.use(
    (response) => {
        return response;
    },

    (error) => {
        const { status } = error.response;

        if (status === 422) {
            Nova.setFormErrors(error.response.data.errors);
        }

        if (status >= 500) {
            Nova.$emit('error', error.response.data.message);
        }

        return Promise.reject(error);
    }
);

export default instance;