import axios from 'axios'

const instance = axios.create()

instance.interceptors.response.use(
	response => response,
	error => {
		const { status } = error.response

		if (status >= 500) {
			Nova.$emit('error', error.response.data.message)
		}

		if (status == 403) {
			//
		}

		return Promise.reject(error)
	}
)

export default instance
